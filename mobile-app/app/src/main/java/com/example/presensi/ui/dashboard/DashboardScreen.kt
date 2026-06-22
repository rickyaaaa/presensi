package com.example.presensi.ui.dashboard

import android.Manifest
import android.content.Context
import android.content.pm.PackageManager
import android.location.Location
import android.widget.Toast
import androidx.activity.compose.rememberLauncherForActivityResult
import androidx.activity.result.contract.ActivityResultContracts
import androidx.compose.foundation.layout.*
import androidx.compose.material3.*
import androidx.compose.runtime.*
import androidx.compose.ui.Alignment
import androidx.compose.ui.Modifier
import androidx.compose.ui.platform.LocalContext
import androidx.compose.ui.text.font.FontWeight
import androidx.compose.ui.unit.dp
import androidx.compose.ui.unit.sp
import androidx.core.content.ContextCompat
import com.example.presensi.data.local.AuthManager
import com.example.presensi.data.network.ApiService
import com.example.presensi.ui.components.CameraCaptureView
import com.example.presensi.utils.LocationHelper
import kotlinx.coroutines.launch
import okhttp3.MediaType
import okhttp3.MultipartBody
import okhttp3.RequestBody
import org.json.JSONObject
import java.io.File
import java.text.SimpleDateFormat
import java.util.Date
import java.util.Locale

@Composable
fun DashboardScreen(onLogout: () -> Unit) {
    val context = LocalContext.current
    val scope = rememberCoroutineScope()
    
    val authManager = remember { AuthManager(context) }
    val locationHelper = remember { LocationHelper(context) }

    val userName = authManager.getUserName() ?: "User"
    val userRole = authManager.getUserRole() ?: "Pegawai"
    val todayDate = SimpleDateFormat("EEEE, dd MMMM yyyy", Locale("id", "ID")).format(Date())

    var activeStatus by remember { mutableStateOf<String?>(null) } // "masuk" or "pulang"
    var showCamera by remember { mutableStateOf(false) }
    var currentLatitude by remember { mutableDoubleStateOf(0.0) }
    var currentLongitude by remember { mutableDoubleStateOf(0.0) }

    var isLoading by remember { mutableStateOf(false) }
    var alertTitle by remember { mutableStateOf("") }
    var alertMessage by remember { mutableStateOf("") }
    var showAlert by remember { mutableStateOf(false) }

    // Request permissions launcher
    val permissionsLauncher = rememberLauncherForActivityResult(
        contract = ActivityResultContracts.RequestMultiplePermissions()
    ) { permissions ->
        val fineLoc = permissions[Manifest.permission.ACCESS_FINE_LOCATION] ?: false
        val coarseLoc = permissions[Manifest.permission.ACCESS_COARSE_LOCATION] ?: false
        val camera = permissions[Manifest.permission.CAMERA] ?: false

        if (fineLoc && coarseLoc && camera) {
            // Permissions granted, restart the action
            activeStatus?.let { triggerPresenceFlow(it, locationHelper, scope) { lat, lon ->
                currentLatitude = lat
                currentLongitude = lon
                showCamera = true
            } }
        } else {
            Toast.makeText(context, "Izin Lokasi dan Kamera dibutuhkan untuk absensi.", Toast.LENGTH_LONG).show()
        }
    }

    if (showCamera) {
        CameraCaptureView(
            onImageCaptured = { file ->
                showCamera = false
                scope.launch {
                    uploadPresence(
                        token = authManager.getToken() ?: "",
                        latitude = currentLatitude,
                        longitude = currentLongitude,
                        status = activeStatus ?: "masuk",
                        file = file,
                        onLoading = { isLoading = it },
                        onResult = { title, message ->
                            alertTitle = title
                            alertMessage = message
                            showAlert = true
                        }
                    )
                }
            },
            onClose = {
                showCamera = false
                activeStatus = null
            }
        )
    } else {
        Box(
            modifier = Modifier
                .fillMaxSize()
                .padding(16.dp)
        ) {
            Column(
                modifier = Modifier
                    .fillMaxSize()
                    .align(Alignment.TopCenter),
                horizontalAlignment = Alignment.CenterHorizontally,
                verticalArrangement = Arrangement.Top
            ) {
                Spacer(modifier = Modifier.height(32.dp))

                // Welcome Header
                Text(
                    text = "Halo, $userName",
                    fontSize = 28.sp,
                    fontWeight = FontWeight.Bold,
                    color = MaterialTheme.colorScheme.primary,
                    modifier = Modifier.padding(bottom = 8.dp)
                )

                Text(
                    text = "Jabatan: $userRole",
                    fontSize = 16.sp,
                    color = MaterialTheme.colorScheme.onSurfaceVariant,
                    modifier = Modifier.padding(bottom = 24.dp)
                )

                Divider(color = MaterialTheme.colorScheme.outlineVariant, thickness = 1.dp)

                Spacer(modifier = Modifier.height(24.dp))

                // Date display
                Text(
                    text = todayDate,
                    fontSize = 18.sp,
                    fontWeight = FontWeight.SemiBold,
                    modifier = Modifier.padding(bottom = 32.dp)
                )

                // Absen Masuk Button
                Button(
                    onClick = {
                        activeStatus = "masuk"
                        if (hasRequiredPermissions(context)) {
                            triggerPresenceFlow("masuk", locationHelper, scope) { lat, lon ->
                                currentLatitude = lat
                                currentLongitude = lon
                                showCamera = true
                            }
                        } else {
                            permissionsLauncher.launch(
                                arrayOf(
                                    Manifest.permission.ACCESS_FINE_LOCATION,
                                    Manifest.permission.ACCESS_COARSE_LOCATION,
                                    Manifest.permission.CAMERA
                                )
                            )
                        }
                    },
                    modifier = Modifier
                        .fillMaxWidth()
                        .height(60.dp)
                        .padding(bottom = 16.dp),
                    colors = ButtonDefaults.buttonColors(containerColor = MaterialTheme.colorScheme.primary),
                    enabled = !isLoading
                ) {
                    Text("Absen Masuk", fontSize = 18.sp, fontWeight = FontWeight.Bold)
                }

                // Absen Pulang Button
                Button(
                    onClick = {
                        activeStatus = "pulang"
                        if (hasRequiredPermissions(context)) {
                            triggerPresenceFlow("pulang", locationHelper, scope) { lat, lon ->
                                currentLatitude = lat
                                currentLongitude = lon
                                showCamera = true
                            }
                        } else {
                            permissionsLauncher.launch(
                                arrayOf(
                                    Manifest.permission.ACCESS_FINE_LOCATION,
                                    Manifest.permission.ACCESS_COARSE_LOCATION,
                                    Manifest.permission.CAMERA
                                )
                            )
                        }
                    },
                    modifier = Modifier
                        .fillMaxWidth()
                        .height(60.dp),
                    colors = ButtonDefaults.buttonColors(containerColor = MaterialTheme.colorScheme.secondary),
                    enabled = !isLoading
                ) {
                    Text("Absen Pulang", fontSize = 18.sp, fontWeight = FontWeight.Bold)
                }

                if (isLoading) {
                    Spacer(modifier = Modifier.height(32.dp))
                    CircularProgressIndicator()
                }
            }

            // Logout Button at the bottom
            Button(
                onClick = {
                    authManager.clear()
                    onLogout()
                },
                modifier = Modifier
                    .fillMaxWidth()
                    .align(Alignment.BottomCenter)
                    .padding(bottom = 24.dp)
                    .height(50.dp),
                colors = ButtonDefaults.buttonColors(containerColor = MaterialTheme.colorScheme.error)
            ) {
                Text("Keluar (Logout)", fontSize = 16.sp, color = MaterialTheme.colorScheme.onError)
            }
        }
    }

    if (showAlert) {
        AlertDialog(
            onDismissRequest = { showAlert = false },
            title = { Text(alertTitle) },
            text = { Text(alertMessage) },
            confirmButton = {
                TextButton(onClick = { showAlert = false }) {
                    Text("OK")
                }
            }
        )
    }
}

private fun hasRequiredPermissions(context: Context): Boolean {
    val fineLoc = ContextCompat.checkSelfPermission(context, Manifest.permission.ACCESS_FINE_LOCATION) == PackageManager.PERMISSION_GRANTED
    val coarseLoc = ContextCompat.checkSelfPermission(context, Manifest.permission.ACCESS_COARSE_LOCATION) == PackageManager.PERMISSION_GRANTED
    val camera = ContextCompat.checkSelfPermission(context, Manifest.permission.CAMERA) == PackageManager.PERMISSION_GRANTED
    return fineLoc && coarseLoc && camera
}

private fun triggerPresenceFlow(
    status: String,
    locationHelper: LocationHelper,
    scope: kotlinx.coroutines.CoroutineScope,
    onLocationAcquired: (Double, Double) -> Unit
) {
    scope.launch {
        val location: Location? = locationHelper.getCurrentLocation()
        if (location != null) {
            val isMock = locationHelper.isMockLocation(location)
            if (isMock) {
                onLocationAcquired(-999.0, -999.0)
            } else {
                onLocationAcquired(location.latitude, location.longitude)
            }
        } else {
            onLocationAcquired(0.0, 0.0) // Fallback coordinates
        }
    }
}

private suspend fun uploadPresence(
    token: String,
    latitude: Double,
    longitude: Double,
    status: String,
    file: File,
    onLoading: (Boolean) -> Unit,
    onResult: (String, String) -> Unit
) {
    if (latitude == -999.0 && longitude == -999.0) {
        onResult("Kecurangan Terdeteksi", "Aplikasi mendeteksi penggunaan Fake GPS / Mock Location. Harap matikan aplikasi GPS tiruan Anda untuk melanjutkan absensi.")
        return
    }

    onLoading(true)
    try {
        val bearerToken = "Bearer $token"

        val mediaType = MediaType.parse("text/plain")
        val latBody = RequestBody.create(mediaType, latitude.toString())
        val lonBody = RequestBody.create(mediaType, longitude.toString())
        val statusBody = RequestBody.create(mediaType, status)

        val imageMediaType = MediaType.parse("image/*")
        val fileRequestBody = RequestBody.create(imageMediaType, file)
        val imagePart = MultipartBody.Part.createFormData("image", file.name, fileRequestBody)

        val apiService = ApiService.create()
        val response = apiService.presensi(bearerToken, latBody, lonBody, statusBody, imagePart)

        if (response.isSuccessful) {
            val body = response.body()
            if (body != null && body.success) {
                onResult("Absensi Sukses", body.message)
            } else {
                onResult("Absensi Gagal", body?.message ?: "Gagal merekam kehadiran.")
            }
        } else {
            val errorBody = response.errorBody()?.string()
            val errorMsg = try {
                JSONObject(errorBody ?: "").getString("message")
            } catch (e: Exception) {
                "Gagal terhubung ke database presensi."
            }
            onResult("Presensi Gagal", errorMsg)
        }
    } catch (e: Exception) {
        onResult("Koneksi Error", "Gagal menghubungi server absensi: ${e.localizedMessage ?: "Connection Refused."}")
    } finally {
        onLoading(false)
    }
}

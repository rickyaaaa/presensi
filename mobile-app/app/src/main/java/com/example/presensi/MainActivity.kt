package com.example.presensi

import android.os.Bundle
import android.widget.Toast
import androidx.activity.ComponentActivity
import androidx.activity.compose.setContent
import androidx.compose.foundation.layout.fillMaxSize
import androidx.compose.material3.MaterialTheme
import androidx.compose.material3.Surface
import androidx.compose.runtime.*
import androidx.compose.ui.Modifier
import com.example.presensi.data.local.AuthManager
import com.example.presensi.ui.dashboard.DashboardScreen
import com.example.presensi.ui.login.LoginScreen

class MainActivity : ComponentActivity() {
    override fun onCreate(savedInstanceState: Bundle?) {
        super.onCreate(savedInstanceState)
        
        setContent {
            val authManager = remember { AuthManager(applicationContext) }
            var isLoggedIn by remember { mutableStateOf(authManager.isLoggedIn()) }

            MaterialTheme {
                Surface(
                    modifier = Modifier.fillMaxSize(),
                    color = MaterialTheme.colorScheme.background
                ) {
                    if (isLoggedIn) {
                        DashboardScreen(
                            onLogout = {
                                isLoggedIn = false
                                Toast.makeText(this@MainActivity, "Berhasil keluar.", Toast.LENGTH_SHORT).show()
                            }
                        )
                    } else {
                        LoginScreen(
                            onLoginSuccess = {
                                isLoggedIn = true
                                Toast.makeText(this@MainActivity, "Login sukses!", Toast.LENGTH_SHORT).show()
                            }
                        )
                    }
                }
            }
        }
    }
}

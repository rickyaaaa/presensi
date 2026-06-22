package com.example.presensi.data.model

import com.google.gson.annotations.SerializedName

data class PresensiResponse(
    @SerializedName("success")
    val success: Boolean,
    
    @SerializedName("message")
    val message: String,
    
    @SerializedName("data")
    val data: PresensiData?
)

data class PresensiData(
    @SerializedName("kehadiran")
    val kehadiran: KehadiranData?,
    
    @SerializedName("image_url")
    val imageUrl: String?
)

data class KehadiranData(
    @SerializedName("id")
    val id: Int,
    
    @SerializedName("user_id")
    val userId: Int,
    
    @SerializedName("jadwal_latitude")
    val jadwalLatitude: Double,
    
    @SerializedName("jadwal_longitude")
    val jadwalLongitude: Double,
    
    @SerializedName("start_latitude")
    val startLatitude: Double,
    
    @SerializedName("start_longitude")
    val startLongitude: Double,
    
    @SerializedName("end_latitude")
    val endLatitude: Double?,
    
    @SerializedName("end_longitude")
    val endLongitude: Double?,
    
    @SerializedName("start_time")
    val startTime: String?,
    
    @SerializedName("end_time")
    val endTime: String?,
    
    @SerializedName("image_in")
    val imageIn: String?,
    
    @SerializedName("image_out")
    val imageOut: String?
)

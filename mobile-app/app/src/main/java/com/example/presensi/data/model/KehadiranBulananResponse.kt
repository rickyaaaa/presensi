package com.example.presensi.data.model

import com.google.gson.annotations.SerializedName

data class KehadiranBulananResponse(
    @SerializedName("success") val success: Boolean,
    @SerializedName("message") val message: String,
    @SerializedName("data") val data: List<KehadiranItem>?
)

data class KehadiranItem(
    @SerializedName("start_time") val startTime: String?,
    @SerializedName("end_time") val endTime: String?,
    @SerializedName("created_at") val createdAt: String
)

package com.example.presensi.data.model

import com.google.gson.annotations.SerializedName

data class KehadiranItem(
    @SerializedName("start_time") val startTime: String?,
    @SerializedName("end_time") val endTime: String?,
    @SerializedName("created_at") val createdAt: String
)

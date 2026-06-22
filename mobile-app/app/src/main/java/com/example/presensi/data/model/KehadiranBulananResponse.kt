package com.example.presensi.data.model

import com.google.gson.annotations.SerializedName

data class KehadiranBulananResponse(
    @SerializedName("success") val success: Boolean,
    @SerializedName("message") val message: String,
    @SerializedName("data") val data: List<KehadiranItem>?
)

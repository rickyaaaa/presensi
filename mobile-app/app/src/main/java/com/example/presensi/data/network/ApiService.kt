package com.example.presensi.data.network

import com.example.presensi.data.model.LoginRequest
import com.example.presensi.data.model.LoginResponse
import com.example.presensi.data.model.PresensiResponse
import okhttp3.MultipartBody
import okhttp3.RequestBody
import retrofit2.Response
import retrofit2.Retrofit
import retrofit2.converter.gson.GsonConverterFactory
import retrofit2.http.Body
import retrofit2.http.Header
import retrofit2.http.Multipart
import retrofit2.http.POST
import retrofit2.http.Part

interface ApiService {

    @POST("login")
    suspend fun login(
        @Body request: LoginRequest
    ): Response<LoginResponse>

    @Multipart
    @POST("presensi")
    suspend fun presensi(
        @Header("Authorization") token: String,
        @Part("latitude") latitude: RequestBody,
        @Part("longitude") longitude: RequestBody,
        @Part("status") status: RequestBody,
        @Part image: MultipartBody.Part
    ): Response<PresensiResponse>

    companion object {
        private const val BASE_URL = "http://10.0.2.2:8000/api/v1/"

        fun create(): ApiService {
            return Retrofit.Builder()
                .baseUrl(BASE_URL)
                .addConverterFactory(GsonConverterFactory.create())
                .build()
                .create(ApiService::class.java)
        }
    }
}

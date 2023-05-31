<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\WhatsappController;
use Netflie\WhatsAppCloudApi\Message\Template\Component;



//Route::middleware(['csrf_exempt'])->get('/webhook', [WhatsappController::class, 'webhook']);
// Route::get('/whatsapp', [WhatsappController::class, 'index']);

Route::match(['get', 'post'], '/webhook', [WhatsappController::class, 'webhook']);
Route::get('/webhook-msg', [WhatsappController::class, 'webhookMSG']);

//Route::post('/webhookPost', [WhatsappController::class, 'webhookPost']);

// Route::get('/webhook', [WhatsappController::class, 'webhookNotification']);



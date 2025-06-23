@extends('layouts.app')

@push('styles')
<style>
    #video-container {
        display: flex;
        justify-content: center;
        align-items: center;
        position: relative;
        width: 100%;
        max-width: 400px;
        margin: auto;
    }

    video {
        width: 100%;
        border-radius: 10px;
        border: 3px solid #007bff;
        transform: scaleX(-1); /* Effet miroir */
    }

    .scanner-frame {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        width: 50vw;
        height: 50vw;
        max-width: 250px;
        max-height: 250px;
        border: 4px dashed red;
        border-radius: 5px;
        display: none; /* Caché par défaut */
    }

    #scan-result {
        font-size: 20px;
        font-weight: bold;
        word-wrap: break-word;
        overflow-wrap: break-word;
        max-width: 100%;
        white-space: pre-wrap;
    }

    #switch-camera {
        position: absolute;
        top: 10px;
        right: 10px;
        z-index: 10;
        background-color: rgba(0, 0, 0, 0.5);
        color: white;
        border: none;
        padding: 10px 15px;
        border-radius: 5px;
        display: none;
    }
</style>
@endpush

@section('content')
<div class="container text-center">
    <h1 class="mb-4">Scanner un QR Code</h1>
    <p>Placez le code QR à l'intérieur du cadre pour le scanner</p>

    <div id="video-container">
        <video id="preview"></video>
        <div class="scanner-frame" id="scanner-frame"></div>
        <button id="switch-camera" class="btn btn-secondary">Changer de caméra</button>
    </div>

    <p id="scan-result" class="mt-3 text-success text-break w-100"></p>
</div>
@endsection

@push('scripts')
<script src="{{ asset('js/instascan.min.js') }}"></script>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        let scanner = new Instascan.Scanner({ video: document.getElementById('preview') });
        let cameras = [];
        let currentCameraIndex = 0;
        let scannerFrame = document.getElementById('scanner-frame');
        let scanResult = document.getElementById('scan-result');
        let switchCameraButton = document.getElementById('switch-camera');
        let videoElement = document.getElementById('preview');

        scanner.addListener('scan', function (content) {
            scanResult.innerText = "Scanné avec succès : " + content;

            // Attendre 2 secondes avant la redirection
            setTimeout(() => {
                window.location.href = "{{ route('qrscanner.show', ':hash') }}".replace(':hash', encodeURIComponent(content));
            }, 1000);
        });

        Instascan.Camera.getCameras().then(function (availableCameras) {
            if (availableCameras.length > 0) {
                cameras = availableCameras;

                // Utiliser la caméra arrière si disponible
                let backCamera = cameras.find(camera => camera.name.toLowerCase().includes('back'));
                if (backCamera) {
                    currentCameraIndex = cameras.indexOf(backCamera);
                }

                scanner.start(cameras[currentCameraIndex]).then(() => {
                    scannerFrame.style.display = 'block';
                });

                // Afficher le bouton de changement de caméra si plusieurs caméras
                if (cameras.length > 1) {
                    switchCameraButton.style.display = 'block';
                }
            } else {
                alert("Aucune caméra détectée");
            }
        }).catch(function (e) {
            console.error(e);
            alert("Une erreur est survenue lors de l'accès à la caméra.");
        });

        switchCameraButton.addEventListener('click', function () {
            currentCameraIndex = (currentCameraIndex + 1) % cameras.length;
            scanner.start(cameras[currentCameraIndex]).then(() => {
                scannerFrame.style.display = 'block';
            });
        });
    });
</script>
@endpush

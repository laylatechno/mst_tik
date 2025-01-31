<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;

class ImageService
{
    /**
     * Upload dan konversi gambar ke format WebP
     *
     * @param UploadedFile|null $image
     * @param string $destinationPath
     * @param string|null $oldImage
     * @return string|null
     */
    public function handleImageUpload(?UploadedFile $image, string $destinationPath, ?string $oldImage = null): ?string
    {
        if (!$image) {
            return null;
        }

        // Pastikan path diakhiri dengan slash
        $destinationPath = rtrim($destinationPath, '/') . '/';

        // Hapus gambar lama jika ada
        if ($oldImage && file_exists(public_path($destinationPath . $oldImage))) {
            unlink(public_path($destinationPath . $oldImage));
        }

        // Cek dan buat direktori jika belum ada
        if (!file_exists(public_path($destinationPath))) {
            mkdir(public_path($destinationPath), 0755, true);
        }

        // Validasi tipe MIME
        $imageMimeType = $image->getMimeType();
        if (strpos($imageMimeType, 'image/') !== 0) {
            throw new \Exception('Format file tidak didukung.');
        }

        // Generate nama file
        $originalFileName = $image->getClientOriginalName();
        $imageName = date('YmdHis') . '_' . str_replace(' ', '_', $originalFileName);
        
        // Simpan gambar original
        $image->move(public_path($destinationPath), $imageName);
        
        // Path lengkap
        $sourceImagePath = public_path($destinationPath . $imageName);
        $webpImagePath = public_path($destinationPath . pathinfo($imageName, PATHINFO_FILENAME) . '.webp');

        // Proses konversi ke WebP
        try {
            $sourceImage = match($imageMimeType) {
                'image/jpeg' => imagecreatefromjpeg($sourceImagePath),
                'image/png' => imagecreatefrompng($sourceImagePath),
                default => throw new \Exception('Format gambar tidak didukung untuk konversi.')
            };

            if ($sourceImage) {
                // Convert dan simpan sebagai WebP
                imagewebp($sourceImage, $webpImagePath);
                imagedestroy($sourceImage);
                
                // Hapus file original
                unlink($sourceImagePath);

                // Return nama file WebP
                return pathinfo($imageName, PATHINFO_FILENAME) . '.webp';
            }
        } catch (\Exception $e) {
            // Hapus file yang sudah terupload jika terjadi error
            if (file_exists($sourceImagePath)) {
                unlink($sourceImagePath);
            }
            if (file_exists($webpImagePath)) {
                unlink($webpImagePath);
            }
            throw $e;
        }

        return null;
    }
}
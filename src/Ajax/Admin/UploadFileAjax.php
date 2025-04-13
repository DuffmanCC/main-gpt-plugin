<?php

namespace MainGPT\Ajax\Admin;

if (!defined('ABSPATH')) exit; // Exit if accessed directly

use Throwable;
use Exception;
use MainGPT\AbstractActionable;
use MainGPT\App;
use MainGPT\HookableTrait;
use Smalot\PdfParser\Parser;
use MainGPT\Helpers\Utils;

class UploadFileAjax extends AbstractActionable
{
    use HookableTrait;
    public const AJAX_ACTION = App::ID . '_upload_file_ajax';
    public const INIT_NAME = 'wp_ajax_' . self::AJAX_ACTION;

    public function execute(): void
    {
        try {
            if (!check_ajax_referer('wp_rest', 'security', false)) {
                throw new Exception('Invalid nonce', 403);
            }

            $response = $this->handleFormSubmission();

            wp_send_json([
                'message' => $response
            ], 200);
        } catch (Throwable $exception) {
            Utils::errorLog(__FILE__, __LINE__, $exception);

            wp_send_json(
                [
                    "code" => $exception->getCode(),
                    "message" => $exception->getMessage(),
                ],
                $exception->getCode()
            );
        }
    }

    public function handleFormSubmission(): string | bool
    {
        if (!isset($_FILES['file'])) {
            return false;
        }

        $file = $_FILES['file'];

        if (!isset($file) || $file['error'] !== UPLOAD_ERR_OK) {
            throw new Exception('Error uploading the file.');
        }

        if ($file['type'] !== 'application/pdf') {
            throw new Exception('Invalid file type. Please upload a PDF file.');
        }

        $fileTmpPath = $file['tmp_name'];
        $fileName = $file['name'];
        $targetDirectory = WP_CONTENT_DIR . '/uploads/';
        $targetFilePath = $targetDirectory . $fileName;

        if (!move_uploaded_file($fileTmpPath, $targetFilePath)) {
            throw new Exception('Error uploading the file.');
        }

        $pdfContent = $this->getContentFromPdf($targetFilePath);

        if (!$pdfContent) {
            throw new Exception('Error reading the file.');
        }

        $newPostId = $this->createPostFromPdf($fileName, $pdfContent);

        if (!$newPostId) {
            throw new Exception('Error creating the post.');
        }

        unlink($targetFilePath);

        return 'Post created from PDF file. <a href="' . get_permalink($newPostId) . '" target="_blank" class="tw-underline tw-text-brand-blue"> ' . get_the_title($newPostId) . '</a>';
    }

    private function createPostFromPdf(string $title, string $content): int
    {
        $new_post = [
            'post_title' => $title,
            'post_content' => $content,
            'post_status' => 'publish',
            'tags_input' => ['from pdf'],
            'post_type' => 'post'
        ];

        return wp_insert_post($new_post);
    }

    private function getContentFromPdf(string $targetFilePath): string
    {
        // Initialize and load PDF Parser library 
        $parser = new Parser();

        // Parse pdf file using Parser library 
        $pdf = $parser->parseFile($targetFilePath);

        // Extract text from PDF 
        return $pdf->getText();
    }
}

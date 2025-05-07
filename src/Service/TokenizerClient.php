<?php

namespace MainGPT\Service;

if (!defined('ABSPATH')) exit; // Exit if accessed directly

use Exception;
use Ramsey\Uuid\Uuid;

class TokenizerClient
{
    private function splitText($text, $chunkSize, $chunkOverlap, $separators)
    {
        // Split the text by the provided separators
        $parts = preg_split('/(' . implode('|', array_map('preg_quote', $separators)) . ')/', $text, -1, PREG_SPLIT_DELIM_CAPTURE | PREG_SPLIT_NO_EMPTY);

        $chunks = [];
        $currentPart = '';

        // Loop through the parts and create chunks based on size
        foreach ($parts as $part) {
            $currentPart .= $part;

            // Check if the current chunk exceeds the chunk size
            if (strlen($currentPart) >= $chunkSize) {
                $chunks[] = $currentPart;
                $currentPart = substr($currentPart, -$chunkOverlap); // overlap
            }
        }

        // Add the remaining part as the last chunk if it's non-empty
        if (!empty($currentPart)) {
            $chunks[] = $currentPart;
        }

        return $chunks;
    }

    /**
     * Only splits text into chunks and prepares for embedding. 
     * It doesn't tokenize the text. We don't need tokens in this moment.
     *
     * @param int $size Maximum size of each chunk.
     * @param int $overlap The overlap between chunks.
     * @param string[] $separators Separators to split the text.
     * @param array<int, array<string, string>> $data Data with text to process.
     * @param int $postId Post ID for storing metadata.
     * @return array
     * @throws Exception
     */
    public function tokenize(
        int $size,
        int $overlap,
        array $separators,
        array $data,
        int $postId
    ): array {
        $response = [];
        $chunks = [];

        update_post_meta($postId, 'tokenizing-percentage', 0);

        $counter = 0;
        $totalChunks = count($data);
        $percentage = 0;

        foreach ($data as $record) {
            // Split the text into chunks based on the defined size and overlap
            $texts = $this->splitText($record['text'], $size, $overlap, $separators);

            // Create chunks with text and metadata
            foreach ($texts as $i => $text) {
                $chunks[] = [
                    'id' => Uuid::uuid4()->toString(),
                    'text' => $text,
                    'chunk' => $i,
                    'url' => $record['url']
                ];
            }

            $counter++;
            $percentage = round(($counter / $totalChunks) * 100, 2);
            update_post_meta($postId, 'tokenizing-percentage', $percentage);
        }

        // Return the chunks for embedding
        $response['chunks'] = $chunks;

        return $response;
    }
}

<?php
namespace MyBlog\Services;

class Uploader {

    const UPLOAD_DIR = '/public/images/uploads'; /* Absolute Path */
    const UPLOAD_DIR_ACCESS_MODE = 0777;
    const UPLOAD_MAX_FILE_SIZE = 10485760;
    const UPLOAD_ALLOWED_MIME_TYPES = [
        'image/jpeg',
        'image/png',
        'image/gif',
    ];

    private $basePath;

    /**
     *
     */
    public function __construct() {
        $this->basePath = $_SERVER['DOCUMENT_ROOT'] . $_SERVER['BASE_URI'];
    }

    // Upload files list
    public function upload(array $files = []) {
        // Normalize
        $normalizedFiles = $this->normalizeFiles($files);

        foreach ($normalizedFiles as $normalizedFile) {
            $uploadResult = $this->uploadFile($normalizedFile);

            if ($uploadResult !== TRUE) {
                $errors[] = $uploadResult;
            }
        }

        // Return TRUE on success, or the errors list
        return empty($errors) ? TRUE : $errors;
    }

    // Normalize file list
    private function normalizeFiles(array $files = []) {
        $normalizedFiles = [];

        foreach ($files as $filesKey => $filesItem) {
            foreach ($filesItem as $itemKey => $itemValue) {
                $normalizedFiles[$itemKey][$filesKey] = $itemValue;
            }
        }

        return $normalizedFiles;
    }

    // Upload file
    private function uploadFile(array $file = []) {
        $name = $file['name'];
        $type = $file['type'];
        $tmpName = $file['tmp_name'];
        $error = $file['error'];
        $size = $file['size'];

        switch ($error) {
            case UPLOAD_ERR_OK: /* No error */
                // Validate file size.
                if ($size > self::UPLOAD_MAX_FILE_SIZE) {
                    return sprintf('The size of the file "%s" exceeds the maximal allowed size (%s Byte).'
                            , $name
                            , self::UPLOAD_MAX_FILE_SIZE
                    );
                }

                // Validate file type.
                if (!in_array($type, self::UPLOAD_ALLOWED_MIME_TYPES)) {
                    return sprintf('The file "%s" is not of a valid MIME type. Allowed MIME types: %s.'
                            , $name
                            , implode(', ', self::UPLOAD_ALLOWED_MIME_TYPES)
                    );
                }

                // Upload path.
                $uploadDirPath = rtrim(self::UPLOAD_DIR, '/');
                $uploadPath = $this->basePath . $uploadDirPath . '/' . $name;

                // Upload directory.
                $this->createDirectory($uploadDirPath);

                // Move file to the new location.
                if (!move_uploaded_file($tmpName, $uploadPath)) {
                    return sprintf('The file "%s" could not be moved to the specified location.'
                            , $name
                    );
                }

                return TRUE;

                break;

            case UPLOAD_ERR_INI_SIZE:
            case UPLOAD_ERR_FORM_SIZE:
                return sprintf('The provided file "%s" exceeds the allowed file size.'
                        , $name
                );
                break;

            case UPLOAD_ERR_PARTIAL:
                return sprintf('The provided file "%s" was only partially uploaded.'
                        , $name
                );
                break;

            case UPLOAD_ERR_NO_FILE:
                return 'No file provided. Please select at least one file.';
                break;

            default:
                return 'There was a problem with the upload. Please try again.';
                break;
        }

        return TRUE;
    }

    // Create directory
    private function createDirectory(string $path) {
        try {
            if (file_exists($path) && !is_dir($path)) {
                throw new \UnexpectedValueException(
                'The upload directory can not be created because '
                . 'a file having the same name already exists!'
                );
            }
        } catch (\Exception $exc) {
            echo $exc->getMessage();
            exit();
        }

        if (!is_dir($path)) {
            mkdir($path, self::UPLOAD_DIR_ACCESS_MODE, TRUE);
        }

        return $this;
    }

}
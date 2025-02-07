<?php 
    class IMG{
        
        public static function validation($img)
        {

            if(
                $img['type'] == 'image/jpeg' ||
                $img['type'] == 'image/jpg' || 
                $img['type'] == 'image/png'
                ){
               
                $size = intval($img['size'] / 1024);

                if($size < 300)
                    return true;
                else
                    return false;
                
            } else{
                return false;
            }
        }

        public static function uploadFile($file){
            $fileFormat = explode('.',$file['name']);
            $imgName = uniqid() . "." . $fileFormat[count($fileFormat) - 1];

            if(move_uploaded_file($file['tmp_name'], BASE_DIR_DASH . '/up/' . $imgName ))
                return $imgName;
            else
                return false;
        }

        public static function deleteFile($file){
            @unlink('up/'.$file);
        }
    }
?>
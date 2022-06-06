<?php 

    /**
     * check if id is is set
     * get the id
     * query the id for specific file
     * get the result
     * check if filepath exist
     * set the headers
     * use readfile() to read the document path
     * redirect to applicant associated with the document
     * 
     * */

    require "functions.php";
    require "../../includes/db.php";

    if (isset($_GET["id"])) {

        $id = $_GET["id"];
        $row = getEndorsementLetterById($conn, $id);
        $filepath = "../../" . $row["endorsement_letter"];

        if (file_exists($filepath)) {
            echo "true";
            header('Content-Description: File Transfer');
            header('Content-Type: application/octet-stream');
            header('Content-Disposition: attachment; filename=' . basename($filepath));
            header('Expires: 0');
            header('Cache-Control: must-revalidate');
            header('Pragma: public');
            header('Content-Length: ' . filesize($filepath));
            readfile($filepath);
        }
    }
?>
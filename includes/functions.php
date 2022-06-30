<?php

    // this sanitizes the data although i'm using prepared statements you can clean the codebase
    function sanitizeData($conn, $data) {
        $data = trim($data);
        $data = mysqli_real_escape_string($conn, $data);
        return $data;
    }

    // prepared statements
    // this inserts all the data from the form
    function saveFormData(
                        $conn,
                        $name,
                        $status,
                        $email,
                        $contactNo,
                        $school,
                        $branch,
                        $course,
                        $skills,
                        $fow,
                        $resume,
                        $created_at) 
    {
        $stmt = mysqli_stmt_init($conn);
        $query = "INSERT INTO application_portal (
            name, 
            status, 
            email, 
            contact_no, 
            school, 
            branch, 
            course, 
            skills,
            field_of_work,
            resume,
            created_at) 
            VALUES (?,?,?,?,?,?,?,?,?,?,?)";
        $stmt = mysqli_prepare($conn, $query);
        mysqli_stmt_bind_param($stmt, "sssssssssss", 
            $name, 
            $status, 
            $email, 
            $contactNo, 
            $school, 
            $branch, 
            $course, 
            $skills,
            $fow,
            $resume,
            $created_at);
        mysqli_stmt_execute($stmt);
        mysqli_close($conn);
    }
<?php require "includes/header.php" ?>
<h2 class="text-center mb-3">Application Form</h2>
<div class="container col">
    <form class="p-5 rounded shadow" action="<?php htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST" enctype="multipart/form-data">
        <div class="row">
            <div class="mb-2 col-lg-4">
                <label for="name" class="form-label">Name</label>
                <input class="form-control" name="name" type="text" id="name" placeholder="enter-name" /> <br>
            </div>
            <div class="mb-2 col-lg-4">
                <label for="email_address" class="form-label">Email</label>
                <input class="form-control" name="email_address" type="email" id="email_address" placeholder="enter-email" /> <br>
            </div>
            <div class="mb-2 col-lg-4">
                <label for="field_of_work" class="form-label">Field of work</label>
                <select name="field_of_work" class="form-select">
                    <option value="">select</option>
                    <option value="Advertising">Advertising</option>
                    <option value="Broadcasting">Broadcasting</option>
                    <option value="Communication">Communication</option>
                    <option value="Digital Design">Digital Design</option>
                    <option value="English Major">English Major</option>
                    <option value="Filipino Major">Filipino Major</option>
                    <option value="Financial Management">Financial Management</option>
                    <option value="Fine Arts">Fine Arts</option>
                    <option value="Graphic Artists">Graphic Artists</option>
                    <option value="Human Resources">Human Resources</option>
                    <option value="Journalism">Journalism</option>
                    <option value="Marketing">Marketing</option>
                    <option value="Multimedia">Multimedia</option>
                    <option value="Nutrition & Food Technology">Nutrition & Food Technology</option>
                    <option value="Office Administration">Office Administration</option>
                    <option value="Public Relations">Public Relations</option>
                    <option value="Web & App Developers">Web & App Developers</option>
                </select> <br>
            </div>
        </div>
        <div class="row">
            <div class="mb-2 col-lg-2">
                <label for="status" class="form-label">Contact Number</label>
                <input class="form-control" name="contact_number" type="text" placeholder="09xxxxxxxxx"/> <br>
            </div>
            <div class="mb-2 col-lg-5">
                <label for="school" class="form-label">School</label>
                <input class="form-control" name="school" type="text" placeholder="enter-school"/> <br>
            </div>
            <div class="mb-2 col-lg-5">
                <label for="branch" class="form-label">Branch</label>
                <input class="form-control" name="branch" type="text" placeholder="enter-branch"/> <br>
            </div>
        </div>
        <div class="row">
            <div class="mb-2 col-lg-4">
                <label for="course" class="form-label">Course</label>
                <input class="form-control" name="course" type="text" placeholder="enter-course"/> <br>
            </div>
            <div class="mb-2 col-lg-6">
                <label for="status" class="form-label">Technical Skills</label>
                <input class="form-control" name="technical_skills" type="text" /> <br>
            </div>
            <div class="mb-2 col-lg-2">
                <label for="resume" class="form-label">Resume</label>
                <input class="form-control" type="file" name="resume">
            </div>
        </div>
        <div class="row mb-3">
            <div class="mb-2 col-lg-6">
                <label for="moa" class="form-label">MOA</label>
                <input class="form-control" type="file" name="moa">
            </div>
            <div class="mb-2 col-lg-6">
                <label for="endorsement_letter" class="form-label">Endorsement Letter</label>
                <input class="form-control w-100" type="file" name="endorsement_letter">
            </div>
        </div>
        <input type="submit" class="btn btn-primary" name="submit"/>

        <?php if(isset($_GET["error"])): ?>
            <div class="alert alert-danger mt-3">
                Please fill all the fields!
            </div>
        <?php endif; ?>

    </form>
</div>
<?php require "includes/footer.php" ?>
<!DOCTYPE html>

<html lang="en">

<body>

  <div class="container">
    <div class="row justify-content-center">
      <div class="col-md-12">
        <div class="card mt-5">
          <div class="card-header">
            <h4>
              MGHS Services
            </h4>
          </div>

          <div class="card-body">

            <form action="" method="GET">
              <div class="row">
                <div class="card mt-4">
                  <div class="input-group mb-3">
                    <select name="sort_data" class="form-control">
                      <option value="">--Select option--</option>
                      <option value="a-z" <?php if (isset($_GET['sort_data']) && $_GET['sort_data'] == "a-z") {
                                            echo "selected";
                                          } ?>>Name Ascending Order (A-Z)</option>
                      <option value="z-a" <?php if (isset($_GET['sort_data']) && $_GET['sort_data'] == "z-a") {
                                            echo "selected";
                                          } ?>>Name Descending Order (Z-A)</option>
                      <option value="Pre-screening" <?php if (isset($_GET['sort_data']) && $_GET['sort_data'] == "Pre-screening") {
                                                      echo "selected";
                                                    } ?>>Pre-screening</option>
                      <option value="Waitlisted" <?php if (isset($_GET['sort_data']) && $_GET['sort_data'] == "Waitlisted") {
                                                    echo "selected";
                                                  } ?>>Waitlisted</option>
                      <option value="Probation" <?php if (isset($_GET['sort_data']) && $_GET['sort_data'] == "Probation") {
                                                  echo "selected";
                                                } ?>>Probation</option>
                      <option value="Qualified" <?php if (isset($_GET['sort_data']) && $_GET['sort_data'] == "Qualified") {
                                                  echo "selected";
                                                } ?>>Qualified</option>
                    </select>
                    <button type="submit" class="input-group-text btn btn-primary" id="basic-addon2">
                      SORT
                    </button>


                    <div class="table-responsive">
                      <table class="table table-bordered">
                        <thead>
                          <tr>
                            <th>name </th>
                            <th>status </th>
                            <th>email </th>
                            <th>contact_no </th>
                            <th>school </th>
                            <th>branch </th>
                            <th>course </th>
                            <th>skills </th>
                            <th>field_of_work </th>
                            <th>resume </th>
                            <th>created_at</th>
                          </tr>
                        </thead>
                        <tbody>

                          <?php

                          $sort_option = "";

                          if (isset($_GET['sort_data'])) {
                            if ($_GET['sort_data'] == "a-z") {
                              $sort_option = "ASC";
                            } elseif ($_GET['sort_data'] == "z-a") {
                              $sort_option = "DESC";
                            }

                            if ($_GET['sort_data'] == "Pre-screening") {
                              $sort_option = "ASC";
                            } elseif ($_GET['sort_data'] == "Waitlisted") {
                              $sort_option = "ASC";
                            } elseif ($_GET['sort_data'] == "Probation") {
                              $sort_option = "ASC";
                            } elseif ($_GET['sort_data'] == "Qualified") {
                              $sort_option = "ASC";
                            }
                          }

                          define("DB_HOST", "remotemysql.com");
                          define("DB_USER", "9zlSnVBorN");
                          define('DB_PWD', "TB7jEOOij0");
                          define('DB', "9zlSnVBorN");

                          $conn = mysqli_connect(DB_HOST, DB_USER, DB_PWD, DB);

                          $query = "SELECT * FROM application_portal ORDER BY name OR status " . $sort_option;
                          $query_run = mysqli_query($conn, $query);

                          if (mysqli_num_rows($query_run) > 0) {
                            foreach ($query_run as $row) {
                          ?>
                              <tr>
                                <td><?= $row['name'] ?></td>
                                <td><?= $row['status'] ?></td>
                                <td><?= $row['email'] ?></td>
                                <td><?= $row['contact_no'] ?></td>
                                <td><?= $row['school'] ?></td>
                                <td><?= $row['branch'] ?></td>
                                <td><?= $row['course'] ?></td>
                                <td><?= $row['skills'] ?></td>
                                <td><?= $row['field_of_work'] ?></td>
                                <td><?= $row['resume'] ?></td>
                                <td><?= $row['created_at'] ?></td>
                              </tr>
                            <?php
                            }
                          } else {
                            ?>
                            <tr>
                              <td colspan="11"> No Record Found </td>
                            </tr>
                          <?php
                          }
                          ?>


                        </tbody>
                      </table>
                    </div>
                  </div>
                </div>
              </div>
          </div>
        </div>
</body>

</html>
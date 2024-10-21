<?php

include_once "./include/header.php";
include_once "./scripts/DB.php";

if (!isset($_GET['provider'])) {
    header('Location: index.php');
    exit();
}

$provider = DB::query("SELECT * FROM providers WHERE id=?", [$_GET['provider']])->fetch(PDO::FETCH_OBJ);

if ($provider === false) {
    header('Location: index.php');
    exit();
}

// Fetch provider's average rating from reviews
$reviews_query = DB::query("SELECT AVG(rating) as avg_rating, COUNT(*) as review_count FROM reviews WHERE provider_id=?", [$provider->id]);
$review_data = $reviews_query->fetch(PDO::FETCH_OBJ);

$average_rating = $review_data->avg_rating ? round($review_data->avg_rating, 1) : 'No ratings yet'; // Show the average rating or a message if there are no ratings
$review_count = $review_data->review_count;

include_once "msg/booking.php";
?>

<div class="container" style="margin-top: 30px;">
    <div class="card text-center">
        <div class="card-header">
            <h3>Details about <?= htmlspecialchars($provider->name); ?></h3>
        </div>
        <div class="container" style="margin-top: 30px;">
            <div class="row">
                <div class="col">
                    <img style="height: 250px" src="images/<?= htmlspecialchars($provider->photo); ?>" alt="<?= htmlspecialchars($provider->name); ?>">
                </div>
            </div>
        </div>

        <div class="card-body">
            <table class="table">
                <tr>
                    <th>Name</th>
                    <td>
                        <?= htmlspecialchars($provider->name); ?>
                    </td>
                    <th>Profession</th>
                    <td>
                        <?= htmlspecialchars($provider->profession); ?>
                    </td>
                </tr>
                <tr>
                    <th>Address</th>
                    <td>
                        <?= htmlspecialchars($provider->adder1); ?>, <?= htmlspecialchars($provider->adder2); ?>
                    </td>
                    <th>Area</th>
                    <td>
                        <?= htmlspecialchars($provider->city); ?>
                    </td>
                </tr>
                <tr>
                    <th>Average Rating</th>
                    <td colspan="3">
                        <?= $average_rating; ?> (<?= $review_count; ?> reviews)
                    </td>
                </tr>
            </table>
        </div>
    </div>
</div>

<div class="container" style="margin-bottom: 60px;margin-top: 20px;">
    <div class="card">
        <div class="card-body">
            <div class="card-title">
                <h3 class="text-center">Book service from <?= htmlspecialchars($provider->name); ?></h3>
            </div>
            <hr>

            <form action="scripts/bookhall.php" method="post">
                <input type="hidden" name="provider" value="<?= htmlspecialchars($provider->id); ?>">
                <div class="form-group">
                    <label for="name"> Name</label>
                    <input id="name" name="name" type="text" class="form-control" placeholder=" Name" required>
                </div>


                <div class="form-group">
                    <label for="contact">Contact No.</label>
                    <input id="contact" name="contact" type="text" class="form-control" placeholder="Contact No."
                           minlength="10" maxlength="10"
                           oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" required>
                </div>

                <div class="form-group">
                    <label for="adder">Address</label>
                    <input id="adder" name="adder" type="text" class="form-control" placeholder="Address" maxlength="255" required>
                </div>

                <div class="form-group">
                    <label for="date">Date on service needed</label>
                    <input class="form-control" type="date" name="date" id="date" required>
                </div>

                <div class="form-group">
                    <label for="payment">Payment Mode</label>
                    <select class="form-control" name="payment" id="payment" required>
                        <option value="cash">Cash</option>
                        <option value="card">Debit Card</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="queries">Problem</label>
                    <textarea id="queries" name="queries" class="form-control" maxlength="255" placeholder="Place your service or issue to be fixed"></textarea>
                </div>

                <button style="margin-top: 30px" class="btn btn-block btn-primary" type="submit" name="book" id="book">Book service</button>
            </form>

        </div>
    </div>
</div>

<?php include_once "include/footer.php"; ?>

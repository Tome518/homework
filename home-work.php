<?php
$user    = ['name' => '', 'age' => '', 'email' => '', 'password' => '', 'terms' => '', 'height' => '0', 'weight' => '0', ];        // Initialize
$errors  = ['name' => '', 'age' => '', 'email' => '', 'password' => '', 'terms' => '', 'height' => '', 'weight' => '', ]; // Initialize
$message = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {                      // If form submitted
    // Validation filters
    $validation_filters['name']['filter']              = FILTER_VALIDATE_REGEXP;
    $validation_filters['name']['options']['regexp']   = '/^[a-zA-Z]{2,10}$/'; //صححت
    $validation_filters['age']['filter']               = FILTER_VALIDATE_INT;
    $validation_filters['age']['options']['min_range'] = 16;
    $validation_filters['age']['options']['max_range'] = 65;
    $validation_filters['email']['filter']              = FILTER_VALIDATE_EMAIL;// add from me FILTER_VALIDATE_EMAIL it was FILTER_VALIDATE_REGEXP
    $validation_filters['email']['options']['regexp']   = '/^[a-zA-Z][a-zA-Z0-9]*@[a-zA-Z0-9]+\.[a-zA-Z0-9]+$/';//add from me 1 letter ai lest first then @ then 1 letter then . then 1 letter
    $validation_filters['password']['filter']              = FILTER_VALIDATE_REGEXP;//add from me
    $validation_filters['password']['options']['regexp']   = '/^[A-Z][A-Za-z0-9!@#$%^&*]{8,32}$/'; // 1 letrer capital then 8-32 letter or numbers or 1special characters at least 
    $validation_filters['terms']                       = FILTER_VALIDATE_BOOLEAN;

    $validation_filters['height']['filter']               = FILTER_VALIDATE_INT;
    $validation_filters['height']['options']['min_range'] = 100;
    $validation_filters['height']['options']['max_range'] = 250;

    $validation_filters['weight']['filter']               = FILTER_VALIDATE_INT;
    $validation_filters['weight']['options']['min_range'] = 30;
    $validation_filters['weight']['options']['max_range'] = 150;

    $user = filter_input_array(INPUT_POST, $validation_filters); // Validate data

    // Create error messages
    $errors['name']  = $user['name']  ? '' : 'Name must be 2-10 letters using A-z';
    $errors['age']   = $user['age']   ? '' : 'You must be 16-65';
    $errors['email']  = $user['email']  ? '' : 'email must be have "@" and "." ';
    $errors['password']  = $user['password']  ? '' : 'Password must be 8-32 characters, start with a capital letter, and contain letters, numbers, or special characters';
    $errors['terms'] = $user['terms'] ? '' : 'You must agree to the terms and conditions';
    $errors['height'] = $user['height'] ? '' : 'Height must be between 100 and 250 cm';
    $errors['weight'] = $user['weight'] ? '' : 'Weight must be between 30 and 150 kg';
    $invalid = implode($errors);                                 // Join error messages

    if ($invalid) {                                              // If there are errors
        $message = 'Please correct the following errors:';       // Do not process
    } else {                                                     // Otherwise
        $message = 'Thank you, your data was valid.';            // Can process data
    }

    // Sanitizate data
    $user['name'] = filter_var($user['name'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $user['age']  = filter_var($user['age'],  FILTER_SANITIZE_NUMBER_INT);
    $user['email'] = filter_var($user['email'], FILTER_SANITIZE_EMAIL);
    $user['password'] = filter_var($user['password'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $user['height'] = filter_var($user['height'], FILTER_SANITIZE_NUMBER_INT);
    $user['weight'] = filter_var($user['weight'], FILTER_SANITIZE_NUMBER_INT);

  
}
?>
<!-- <?php include 'includes/index.html'; ?>
<?php include 'includes/index.css'; ?> -->

<?= $message ?>
<form action="home-work.php" method="POST">
  Name: <input type="text" name="name" value="<?= $user['name'] ?>">
  <span class="error"><?= $errors['name'] ?></span><br>
  Age: <input type="text" name="age" value="<?= $user['age'] ?>">
  <span class="error"><?= $errors['age'] ?></span><br>

  email: <input type="text" name="email" value="<?= $user['email'] ?>">
  <span class="error"><?= $errors['email'] ?></span><br>
  password: <input type="text" name="password" value="<?= $user['password'] ?>">
  <span class="error"><?= $errors['password'] ?></span><br>

    height: <input type="text" name="height" value="<?= $user['height'] ?>">
    <span class="error"><?= $errors['height'] ?></span><br>
    weight: <input type="text" name="weight" value="<?= $user['weight'] ?>">
    <span class="error"><?= $errors['weight'] ?></span><br>

  <input type="checkbox" name="terms" value="true"
      <?= $user['terms'] ? 'checked' : '' ?>> I agree to the terms and conditions<br>
  <span class="error"><?= $errors['terms'] ?></span>
   <p style="color: red;">your BIM is </p> <?php echo $user['height']/(2*$user['weight']); ?> <br>
  <input type="submit" value="Save">
</form>

<?php
$user    = ['name' => '', 'age' => '', 'email' => '', 'password' => '', 'terms' => '', ];        // Initialize
$errors  = ['name' => '', 'age' => '', 'email' => '', 'password' => '', 'terms' => false, ];
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
    $validation_filters['password']['options']['regexp']   = '/^[A-Z][A-Za-z0-9!@#$%^&*]{8,32}$/' // 1 letrer capital then 8-32 letter or numbers or 1special characters at least 
    $validation_filters['terms']                       = FILTER_VALIDATE_BOOLEAN;

    $user = filter_input_array(INPUT_POST, $validation_filters); // Validate data

    // Create error messages
    $errors['name']  = $user['name']  ? '' : 'Name must be 2-10 letters using A-z';
    $errors['age']   = $user['age']   ? '' : 'You must be 16-65';
    $errors['email']  = $user['email']  ? '' : 'email must be have "@" and "." ';
    $errors['password']  = $user['password']  ? '' : 'Password must be 8-32 characters, start with a capital letter, and contain letters, numbers, or special characters';
    $errors['terms'] = $user['terms'] ? '' : 'You must agree to the terms and conditions';
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
}
?>
<?php include 'includes/index.html'; ?>
<?php include 'includes/index.css'; ?>

<?= $message ?>
<form action="validate-form-using-filters.php" method="POST">
  Name: <input type="text" name="name" value="<?= $user['name'] ?>">
  <span class="error"><?= $errors['name'] ?></span><br>
  Age: <input type="text" name="age" value="<?= $user['age'] ?>">
  <span class="error"><?= $errors['age'] ?></span><br>

  email: <input type="text" name="email" value="<?= $user['email'] ?>">
  <span class="error"><?= $errors['email'] ?></span><br>
  password: <input type="text" name="password" value="<?= $user['password'] ?>">
  <span class="error"><?= $errors['password'] ?></span><br>

  <input type="checkbox" name="terms" value="true"
      <?= $user['terms'] ? 'checked' : '' ?>> I agree to the terms and conditions
  <span class="error"><?= $errors['terms'] ?></span><br>
  <input type="submit" value="Save">
</form>

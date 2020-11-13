<?php
$errors = [];
if(isset($_SESSION['message'])){
    $message = $_SESSION['message'];
    unset($_SESSION['message']);
}else if(isset($exception)){
    $message = [
        'type' => 'error',
        'message' => $exception->getMessage()
    ];

    if(get_class($exception) === 'ValidationException'){
        $errors = $exception->getErrors();
    }
}    
$alertType = (isset($message['type']) and $message['type'] === 'error')?'danger':'success';
?>
<?php if(isset($message) and $message): ?>
<div class="alert alert-<?= $alertType; ?> my-3" role="alert">
    <?= $message['message']; ?>
</div>
<?php endif ?>
</div>

</div>
</div>

<script src="dist/js/scripts.js"></script>
<script src="dist/js/custom.js"></script>

<?php
  if (isset($error_message)) :
?>
<script>
  iziToast.show({
    message: '<?php echo $error_message; ?>',
    position: 'bottomRight',
    color: 'red'
  })
</script>
<?php
  endif;
?>

<?php
  if (isset($success_message)) :
?>
<script>
  iziToast.show({
    message: '<?php echo $success_message; ?>',
    position: 'bottomRight',
    color: 'green'
  })
</script>
<?php
  endif;
?>

<?php
if (isset($_SESSION['success_message'])) {
?>
<script>
iziToast.show({
  message: '<?php echo $_SESSION['success_message']; ?>',
  position: 'bottomRight',
  color: 'green'
})
</script>
<?php
  unset($_SESSION['success_message']);
}
?>

<?php
if (isset($_SESSION['error_message'])) {
?>
<script>
iziToast.show({
  message: '<?php echo $_SESSION['error_message']; ?>',
  position: 'bottomRight',
  color: 'red'
})
</script>
<?php
  unset($_SESSION['error_message']);
}
?>

</body>
</html>
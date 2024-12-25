<footer class="main-footer">
  <div class="pull-right hidden-xs">
    <b>Version</b> <?= config_item("footer_version") ?>
  </div>
  <strong><?= config_item("footer_text") ?> <a href="https://cludotechnology.com" target="_blank">Cludo</a>.</strong>
  All rights reserved.
</footer>
</div>
</body>
<script>
  $(function () {
    $('.select2').select2();
    $(".number").keypress(function (e) {
      // Allow: backspace (8), delete (0), numbers (48-57), and dot (46)
      if (e.which != 8 && e.which != 0 && e.which != 46 && (e.which < 48 || e.which > 57)) {
        return false;
      }
      // Prevent multiple dots
      if ($(this).val().indexOf('.') !== -1 && e.which == 46) {
        return false;
      }
    });

    $('.datepicker').datepicker({
        format: 'dd-mm-yyyy'
    });
  });
</script>

</html>
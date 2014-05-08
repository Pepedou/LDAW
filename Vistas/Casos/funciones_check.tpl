<script>
    function check() {
        var selected = [];

        $(".chk:checked").each(function(index, resultado) {
            selected.push($(this).val());
        });

        newUrl = "altas.php?op=Caso";
        document.location.href = newUrl;
    }
</script>
<script>
function actualiza(id,name) {
newUrl = "cambios.php?nombre=" + name + "&sel=" + id + "&op=Documento";
document.location.href = newUrl;
}

</script>
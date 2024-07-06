document.getElementById('input-search-query').addEventListener('input', function() {
    this.value = this.value.replace(/\s{2,}/g, ' '); // Удаляем повторяющиеся пробелы
});
document.getElementById('phone_number').addEventListener('input', function (e) {
    // Allow only numbers and plus sign
    this.value = this.value.replace(/[^0-9+]/g, '');
});
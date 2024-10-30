document.getElementById('pegawai').addEventListener('submit', function(event) {
    event.preventDefault();

    let valid = true;
    const inputs = document.querySelectorAll('#pegawai input');
    
    inputs.forEach(input => {
      const errorElement = input.nextElementSibling;
      if (input.value.trim() === "") {
        errorElement.classList.add('visible');
        valid = false;
      } else {
        errorElement.classList.remove('visible');
      }
    });

    if (valid) {
      alert("terimakasih telah submit!");
    }
  });
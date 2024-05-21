
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="stylecss/style.css">
</head>
<body>
    <section class="banner">
        <h2>BOOK YOUR TABLE NOW</h2>
        <div class="card-container">
            <div class="card-img">
                <img src="assets/img/logo.png" alt="">
            </div>
        <div class="card-content">
        <h1>Reservation</h1>
        <form>
            <div class="form-row">
                <select name="days" id="">
                    <option value="day-select">Select day</option>
                    <option value="sunday">Sunday</option>
                    <option value="monday">Monday</option>
                    <option value="tuesday">Tuesday</option>
                    <option value="wednesday">Wednesday</option>
                    <option value="thursday">Thursday</option>
                    <option value="friday">Friday</option>
                    <option value="saturday">Saturday</option>
                </select>
                <select name="hours" id="">
                    <option value="hour-select">Select Hour</option>
                    <option value="10">10: 00</option>
                    <option value="10">12: 00</option>
                    <option value="10">14: 00</option>
                    <option value="10">16: 00</option>
                    <option value="10">18: 00</option>
                    <option value="10">20: 00</option>
                    <option value="10">22: 00</option>
                </select>
            </div>
                <div class="form-row">
                    <input type="text"placeholder="Full Name">
                    <input type="text"placeholder="Phone Number">
                </div>

                <div class="d-grid gap-2">
                    <button class="btn btn-primary" type="button">Button</button>
                  </div>
            </form>
        </div>
    </div>
</section>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
<script src="index.js"></script>


</body>
</html>


<style>
    @import url('https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap');


*{
    box-sizing: border-box;
    padding: 0;
    margin: 0;
}

body{
    font-family: 'Poppins',sans-serif;
}

.banner{
    min-height: 100vh;
    background: linear-gradient(rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.5)), url("../img/banner-img.jpg") center/cover no-repeat;
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
    color: #fff;
    padding-bottom: 20px;
}


.card-container{
    display: grid;
    width: 30%;
    margin: 0 auto;
    
}

/* .card-img{
    background: url("../img/card-img.jpg") center/cover no-repeat;
} */

.banner h2{
    padding-bottom: 40px;
    margin-bottom: 20px;
}

.card-content{
    background: #fff;
    height: 355px;
    padding: 5% 5%;
   
}


.card-content h1{
    text-align: center;
    color: #000;
    padding: 10px 0 5px 0;
    font-size: 20px;
    font-weight: 500;
}

.from-row{
    display: flex;
    flex-wrap: wrap;
    width: 90%;
    margin: 15px;
}
form select, 
form input{
    color: #010101;
    margin-right: 10px;
    display: block;
    width: calc(100% - 24px);
    margin: 8px 4px;
    padding: 8px;
    font-size: 15px;
    font-family: 'Poppins', sans-serif;
    outline: none;
    border: none;
    border-bottom: 1px solid #ccc;
    font-weight: 300;
}

.form-row input:last-child {
    margin-right: 0; /* Menghapus margin kanan untuk input terakhir dalam baris */
}

form input[type = text], form input[type = number] {
    color: #010101;
}
form input::placeholder, select{
    color: #aaa;
}

/* form input[type = submit]{
    margin: 0;
    margin-top: 2vh;
    margin-left: 12px;
    color: #fff;
    background: #f2745f;
    padding: 10px 20px;
    border: none;
    border-radius: 4px;
    cursor: pointer;
    transition: 0.3s ease;
}

form input[type = submit]:hover{
    opacity: 0.9;
    color: #e25e4d;
} */

.d-grid.gap-2 {
    margin-top: 5vh;
    display: grid;
    grid-gap: 2rem; /* Adjust spacing between buttons as needed */
    place-items: center; /* Center buttons horizontally and vertically */
  }
  
  .btn-primary {
    background-color: #0d6efd;
    border-color: #0d6efd;
    color: #fff;
    padding: 1rem 2rem;
    font-size: 1rem;
    border: none;
    border-radius: .25rem;
    cursor: pointer;
    transition: all 0.15s ease-in-out;
  }
  
  /* Optional hover effect for a subtle visual cue */
  .btn-primary:hover {
    background-color: #0b5ed7;
    border-color: #0b5ed7;
  } 

@media(max-width:992px){
    .card-container{
        grid-template-columns: 100%;
    }
    .card-img{
        height: 330px;
    }
}
</style>

<script>
    // Mendapatkan waktu saat ini
    var currentTime = new Date();
    var currentHour = currentTime.getHours();

    // Mengecek apakah sudah lewat pukul 22:00 (10 malam) atau belum
    if (currentHour >= 22 || currentHour < 10) {
        // Redirect pengguna ke halaman lain (misalnya halaman utama)
        window.location.href = '/error';
    }
</script>
<?php
    include ("header.php");
    include ("../includes/connection.inc.php");
    $email = print_r($_SESSION["email"], TRUE);
    $sql = "SELECT * FROM employees WHERE emailadd = '$email'";
    $res = mysqli_query($conn, $sql);
    $row = mysqli_fetch_array($res);
?>
        <nav>
            <div class="sidebar-button">
                <i class='fa fa-bars sidebarBtn'></i>
                <span class="dashboard">Welcome Back <?php echo $row['fName']?>!</span>
            </div>
            <div class="time">
                <span class="date"></span>
                <br />
                <span class="hms"></span>
                <span class="ampm"></span>
            </div>
        </nav> 
        <div class="home-content">
            <div class="cardbox">
                <div class="graphbox">

                </div>       
            </div>
        </div>
        </section>
        <script>
            var dropdown = document.getElementsByClassName("dropdown-btn");
            var i;

            for (i = 0; i < dropdown.length; i++) {
                dropdown[i].addEventListener("click", function() {
                    this.classList.toggle("active");
                    var dropdownContent = this.nextElementSibling;
                    if (dropdownContent.style.display === "block") {
                        dropdownContent.style.display = "none";
                    } else {
                        dropdownContent.style.display = "block";
                    }
                });
            }

            const currentLocation = location.href;
            const menuItem = document.querySelectorAll('a');
            const menuLength = menuItem.length
            for (let i = 0; i < menuLength; i++) {
                if(menuItem[i].href === currentLocation){
                    menuItem[i].className = "active"
                }
            }   
            
            let sidebar = document.querySelector(".sidebar");
            let sidebarBtn = document.querySelector(".sidebarBtn");
            var y = document.getElementById("hide1");
            var z = document.getElementById("hide2");

            sidebarBtn.onclick = function() {
            sidebar.classList.toggle("active");

            if(sidebar.classList.contains("active")){
                sidebarBtn.classList.replace("bx-menu" ,"bx-menu-alt-right");

                    y.style.display = "block";
                    z.style.display = "none";
            }else{
                    sidebarBtn.classList.replace("bx-menu-alt-right", "bx-menu");
                    
                    y.style.display = "none";
                    z.style.display = "block";
                }
            }   
                function updateTime() {
                    var dateInfo = new Date();

                    /* time */
                    var hr = dateInfo.getHours(),
                        _min = dateInfo.getMinutes(),
                        sec = dateInfo.getSeconds(),
                        // sec = dateInfo.getSeconds() < 10 ? "0" + dateInfo.getSeconds() : dateInfo.getSeconds(),
                        ampm = dateInfo.getHours() >= 12 ? "PM" : "AM";

                    // replace 0 with 12 at midnight, subtract 12 from hour if 13–23
                    hr = (hr > 12) ? hr -12 : hr

                    hr = ("0" + hr).slice(-2);
                    _min = ("0" + _min).slice(-2);
                    // sec = ("0" + sec).slice(-2);

                    var currentTime = hr + ":" + _min 
                    // + ":" + sec;

                    // print time
                    document.getElementsByClassName("hms")[0].innerHTML = currentTime;
                    document.getElementsByClassName("ampm")[0].innerHTML = ampm;

                    /* date */
                    var dow = ["Sunday", "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday"],
                        month = [
                            "January",
                            "February",
                            "March",
                            "April",
                            "May",
                            "June",
                            "July",
                            "August",
                            "September",
                            "October",
                            "November",
                            "December",
                        ],
                        day = dateInfo.getDate(),
                        year = dateInfo.getFullYear();

                    // store date
                    var currentDate = dow[dateInfo.getDay()] + " | " + day + " " + month[dateInfo.getMonth()] + " " + year;

                    document.getElementsByClassName("date")[0].innerHTML = currentDate;
                }

                // print time and date once, then update them every second
                updateTime();
                setInterval(function () {
                    updateTime();
                }, 1000);                     
        </script>
    </body>
</html>
    <div class="footer-basic mt-4">    
        <footer>
            <h3 class="text-center">La Consolacion College - Liloan, Cebu, Inc.</h3>
            <p class="copyright">LaCoTech © 2022</p>
        </footer>
    </div>    
    <script>
        /* Loop through all dropdown buttons to toggle between hiding and showing its dropdown content - This allows the user to have multiple dropdowns without any conflict */
        let arrow = document.querySelectorAll(".arrow");

        for (var i = 0; i < arrow.length; i++) {
            arrow[i].addEventListener("click", (e) => {
                let arrowParent = e.target.parentElement.parentElement; //selecting main parent of arrow
                arrowParent.classList.toggle("showMenu");
            });
        }
        $(function() {
            $(".nav-links li").eq(parseInt(localStorage.getItem("selected_item_index "))).addClass("showMenu").siblings();
        });
        const currentLocation = location.href;
        const menuItem = document.querySelectorAll('a');
        const menuLength = menuItem.length
        for (let e = 0; e < menuLength; e++) {
            if(menuItem[e].href === currentLocation){
                menuItem[e].className = "active";
            }
        }
                
        function updateTime() {
            var dateInfo = new Date();

            /* time */
            var hr = dateInfo.getHours(),
                _min = dateInfo.getMinutes(),
                sec = dateInfo.getSeconds(),
                ampm = dateInfo.getHours() >= 12 ? "PM" : "AM";

            // replace 0 with 12 at midnight, subtract 12 from hour if 13–23
            hr = (hr > 12) ? hr -12 : hr

            hr = ("0" + hr).slice(-2);
            _min = ("0" + _min).slice(-2);

            var currentTime = hr + ":" + _min 

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

        $(document).ready(function() {
            $('#example').DataTable({
                "pagingType": "full_numbers"
            }); 
        });
    </script>
    </body>
</html>
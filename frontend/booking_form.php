<div id="booking-form">
    <header>
        <h2>Book-A-Ride</h2>
    </header>
    <section>
        <form method="post" action="">
            <!-- <input type="hidden" name="baby_seats" value="" /> -->
            <div id="origin-con" class="item-con"><span class="icon"></span><input type="text" id="origin" name="origin" value="" placeholder="Pickup address" /></div>
            <div id="airport-type-con" class="clearfix item-con">
                <label class="active"><input type="radio" class="airport-type" name="airport_type" value="Domestic" checked />Domestic</label>
                <label><input type="radio" class="airport-type" name="airport_type" value="International" />International</label>
            </div>
            <div id="destination-con" class="item-con"><span class="icon"></span><input type="text" id="destination" name="destination" value="" placeholder="Drop off address" /></div>
            <div class="clearfix item-con">
                <div id="date-con">
                    <span class="icon"></span>
                    <?php echo tb_get_dates(); ?>
                </div>
                <div id="hour-con">
                    <?php echo tb_get_hours(); ?>
                </div>
                <div id="minute-con">
                    <?php echo tb_get_minutes(); ?>
                </div>
                <div id="am-pm-con">
                    <select id="am-pm-dropdown" class="dropdown" name="pickup_date_amorpm">
                        <option value="AM">AM</option>
                        <option value="PM">PM</option>
                    </select>
                </div>
            </div>
            <div id="vehicle-type-con" class="item-con">
                <span class="icon"></span>
                <select id="vehicle-type-dropdown" class="dropdown" name="vehicle_type">
                    <option value="sedan">Holden Caprice</option>
                    <option value="van">Mercedes Benz</option>
                </select>
            </div>
            <div id="baby-seats-con" class="item-con clearfix">
                <span class="icon"></span>
                <div id="babyseats-label">Baby Seats</div>
                <div id="babyseats-controls" class="clearfix">
                    <span class="carat-up"></span><input id="baby-seats" type="text" name="baby_seats" value="" placeholder="0"/><span class="carat-down"></span>
                </div>
            </div>
        </form>
    </section>
    <footer>
        <div id="quote-result" class="clearfix">
            <div id="quote-result-left">
                <h3>Fare</h3>
                <p>* Additional stops will incur an additional charge</p>
            </div>
            <div id="quote-result-right">$0.00*</div>
        </div>
        <div id="metadata" class="clearfix item-con">
            <div id="duration">Duration:&nbsp;&nbsp;&nbsp;<span></span></div>
            <div id="distance">Distance:&nbsp;&nbsp;&nbsp;<span></span></div>
        </div>
        <p id="book-now">
            <a href="#" title="Book Now">Book Now</a>
        </p>
    </footer>   
</div>
<div id="booking-form">
    <header>
        <h2>Book-A-Ride</h2>
    </header>
    <section>
        <form method="post" action="">
            <p><input type="text" id="origin" name="origin" value="" placeholder="Pickup address" /></p>
            <p id="airport-type-con">
                <label><input type="radio" class="airport-type" name="airport_type" value="Domestic" checked />Domestic</label>
                <label><input type="radio" class="airport-type" name="airport_type" value="International" />International</label>
            </p>
            <p><input type="text" id="destination" name="destination" value="" placeholder="Drop off address" /></p>
            <p><input type="text" id="pickup-date" name="pickup_date" value="" placeholder="Date and Time" /></p>
            <p><select id="vehicle-type" name="vehicle_type">
                <option value="sedan">Holden Caprice</option>
                <option value="van">Mercedes Benz</option>
            </select>
            <select id="baby-seats" name="baby_seats">
                <option value="0">None</option>
                <option value="1">1 seat</option>
                <option value="2">2 seats</option>
                <option value="3">3 seats</option>
                <option value="4">4 seats</option>
                <option value="5">5 seats</option>
            </select></p>
        </form>
    </section>
    <footer>
        <div id="quote-result">
            <div id="quote-result-left">
                <h3>Fare</h3>
                <p>* Airport pickups incur a $10 extra fee</p>
            </div>
            <div id="quote-result-right">
            </div>
        </div>
        <p id="book-now">
            <a href="#" title="Book Now">Book Now</a>
        </p>
    </footer>   
</div>
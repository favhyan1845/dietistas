<?php
function form_content()
{
    ?>
<section class="col-md-12 mb-4 mt-4">
    <!-- begin text information  -->
    <h1>Title to pluggin</h1>
    <p class="text-justify">
        Health Profile Directory Plugin: This plugin allows you to manage health provider profiles through an API. It
        facilitates the collection, visualization and updating of health professionals' information, optimizing access
        to relevant data for users.</p>

    </p>
</section>
<!-- end text information  -->
<form id="formProfile">
    <section class="col-md-12 mb-4 mt-4">
        <h4>Profiles List</h4>
        <!-- Profile -->
        <div class="input-group input-group-sm mb-2">
            <label for="healthloft-profile-response-url">Url<span style="color:red">*</label>:
            <div class="input-group-prepend div-input-group">
                <input type="text" class="col-md-6" id="healthloft-profile-response-url"
                    name="healthloft-Profile-response-url"
                    value='<?php echo (get_option('healthloft-profile-response-url')) ? get_option('healthloft-profile-response-url') : ''; ?>'
                    placeholder="https://signin.healthloftco.com/api/providers." required>
            </div>
            <span> Description: Enter the URL of the API from which health provider data is retrieved.<br>Example:
                https://signin.healthloftco.com/api/providers.</span>
        </div>

        <div class="input-group input-group-sm mb-2">
            <label for="healthloft-profile-response-cache">Response:</label>
            <div class="input-group-prepend div-input-group">
                <textarea class="col-md-6" id="healthloft-profile-response-cache"
                    name="healthloft-profile-response-cache"
                    rows="6"><?php echo (get_option('healthloft-profile-response-cache')) ? json_encode(get_option('healthloft-profile-response-cache')) : ''; ?></textarea>
            </div>
            <span><strong>Description:</strong> Enter the URL of the API from which health provider data is
                retrieved.</span>
        </div>

        <div class="input-group input-group-sm mb-2">
            <label for="healthloft-profile-response-cache-date">Date:</label>
            <div class="input-group-prepend div-input-group">
                <input type="text" class="col-md-6" id="healthloft-profile-response-cache-date"
                    name="healthloft-Profile-response-cache-date"
                    value='<?php echo (get_option('healthloft-profile-response-cache-date')) ? get_option('healthloft-profile-response-cache-date') : ''; ?>'>
            </div>
            <span><strong>Description:</strong> This field shows the date and time of the last update of the
                information. It is for
                informational purposes only and is not editable</span>
        </div>

        <div class="input-group input-group-sm mb-2">
            <label for="healthloft-profile-response-cache-ttl">Ttl<span style="color:red">*</label>:
            <div class="input-group-prepend div-input-group">
                <input type="number" class="col-md-6" id="healthloft-profile-response-cache-ttl"
                    name="healthloft-profile-response-cache-ttl"
                    value='<?php echo (is_numeric(get_option('healthloft-profile-response-cache-ttl')) ? get_option('healthloft-profile-response-cache-ttl') : ''); ?>'
                    placeholder="18000 (5 hours)" required>
            </div>
            <span><strong>Description:</strong> Specifies the time (in seconds) during which the API response is
                considered valid. Adjust
                this value based on how frequently you expect the data to change.
                <br>
                <strong>Example: 18000 (5 hours)</strong> </span>
        </div>
    </section>
    <!-- end Profile -->

    <!-- States -->
    <section class="col-md-12 mb-4 mt-4">

        <h4>States</h4>
        <div class="input-group input-group-sm mb-2">
            <label for="healthloft-states-response-url">Url<span style="color:red">*</label>:
            <div class="input-group-prepend div-input-group">
                <input type="text" class="col-md-6" id="healthloft-states-response-url"
                    name="healthloft-states-response-url"
                    value='<?php echo (get_option('healthloft-states-response-url')) ? get_option('healthloft-states-response-url') : ''; ?>'
                    required>
            </div>
            <span><strong>Description:</strong> Enter the URL of the API from which health provider data is
                retrieved.</span>
        </div>

        <div class="input-group input-group-sm mb-2">
            <label for="healthloft-states-response-cache">Response:</label>
            <div class="input-group-prepend div-input-group">
                <textarea class="col-md-6" id="healthloft-states-response-cache" name="healthloft-states-response-cache"
                    rows="6"><?php echo (get_option('healthloft-states-response-cache')) ? json_encode(get_option('healthloft-states-response-cache')) : ''; ?></textarea>
            </div>
            <span><strong>Description:</strong> Enter the URL of the API from which health provider data is
                retrieved.</span>
        </div>

        <div class="input-group input-group-sm mb-2">
            <label for="healthloft-states-response-cache-date">Date:</label>
            <div class="input-group-prepend div-input-group">
                <input type="text" class="col-md-6" id="healthloft-states-response-cache-date"
                    name="healthloft-states-response-cache-date"
                    value='<?php echo (get_option('healthloft-states-response-cache-date')) ? get_option('healthloft-states-response-cache-date') : ''; ?>'>
            </div>
            <span><strong>Description:</strong> This field shows the date and time of the last update of the
                information. It is for
                informational purposes only and is not editable</span>
        </div>

        <div class="input-group input-group-sm mb-2">
            <label for="healthloft-states-response-cache-ttl">Ttl<span style="color:red">*</label>:
            <div class="input-group-prepend div-input-group">
                <input type="number" class="col-md-6" id="healthloft-states-response-cache-ttl"
                    name="healthloft-states-response-cache-ttl"
                    value='<?php echo (is_numeric(get_option('healthloft-states-response-cache-ttl')) ? get_option('healthloft-states-response-cache-ttl') : ''); ?>'
                    required>
            </div>
            <span><strong>Description:</strong> Specifies the time (in seconds) during which the API response is
                considered valid. Adjust
                this value based on how frequently you expect the data to change.
                <br>
                <strong>Example: 18000 (5 hours)</strong></span>
        </div>
    </section>
    <!-- end States -->

    <!-- Specialities -->
    <section class="col-md-12 mb-4 mt-4">
        <h4>Specialities</h4>
        <div class="input-group input-group-sm mb-2">
            <label for="healthloft-specialities-response-url">Url<span style="color:red">*</label>:
            <div class="input-group-prepend div-input-group">
                <input type="text" class="col-md-6" id="healthloft-specialities-response-url"
                    name="healthloft-specialities-response-url"
                    value='<?php echo (get_option('healthloft-specialities-response-url')) ? get_option('healthloft-specialities-response-url') : ''; ?>'
                    required>
            </div>
            <span><strong>Description:</strong> Enter the URL of the API from which health provider data is
                retrieved.</span>
        </div>

        <div class="input-group input-group-sm mb-2">
            <label for="healthloft-specialities-response-cache">Response:</label>
            <div class="input-group-prepend div-input-group">
                <textarea class="col-md-6" id="healthloft-specialities-response-cache"
                    name="healthloft-specialities-response-cache"
                    rows="6"><?php echo (get_option('healthloft-specialities-response-cache')) ? json_encode(get_option('healthloft-specialities-response-cache')) : ''; ?></textarea>
            </div>
            <span><strong>Description:</strong> Enter the URL of the API from which health provider data is
                retrieved.</span>
        </div>

        <div class="input-group input-group-sm mb-2">
            <label for="healthloft-specialities-response-cache-date">Date:</label>
            <div class="input-group-prepend div-input-group">
                <input type="text" class="col-md-6" id="healthloft-specialities-response-cache-date"
                    name="healthloft-specialities-response-cache-date"
                    value='<?php echo (get_option('healthloft-specialities-response-cache-date')) ? get_option('healthloft-specialities-response-cache-date') : ''; ?>'>
            </div>
            <span><strong>Description:</strong> This field shows the date and time of the last update of the
                information. It is for
                informational purposes only and is not editable</span>
        </div>

        <div class="input-group input-group-sm mb-2">
            <label for="healthloft-specialities-response-cache-ttl">Ttl<span style="color:red">*</span>:</label>
            <div class="input-group-prepend div-input-group">
                <input type="number" class="col-md-6" id="healthloft-specialities-response-cache-ttl"
                    name="healthloft-specialities-response-cache-ttl"
                    value='<?php echo (is_numeric(get_option('healthloft-specialities-response-cache-ttl')) ? get_option('healthloft-specialities-response-cache-ttl') : ''); ?>'
                    required>
            </div>
            <span><strong>Description:</strong> Specifies the time (in seconds) during which the API response is
                considered valid. Adjust
                this value based on how frequently you expect the data to change.
                <br>
                <strong>Example: 18000 (5 hours)</strong></span>
        </div>
    </section>
    <!-- Specialities profile -->

    <!-- Age Ranges -->
    <section class="col-md-12 mb-4 mt-4">
        <h4>Age Ranges</h4>
        <div class="input-group input-group-sm mb-2">
            <label for="healthloft-age_ranges-response-url">Url<span style="color:red">*</label>:
            <div class="input-group-prepend div-input-group">
                <input type="text" class="col-md-6" id="healthloft-age_ranges-response-url"
                    name="healthloft-age_ranges-response-url"
                    value='<?php echo (get_option('healthloft-age_ranges-response-url')) ? get_option('healthloft-age_ranges-response-url') : ''; ?>'
                    required>
            </div>
            <span><strong>Description:</strong> Enter the URL of the API from which health provider data is
                retrieved.</span>
        </div>

        <div class="input-group input-group-sm mb-2">
            <label for="healthloft-age_ranges-response-cache">Response:</label>
            <div class="input-group-prepend div-input-group">
                <textarea class="col-md-6" id="healthloft-age_ranges-response-cache"
                    name="healthloft-age_ranges-response-cache"
                    rows="6"><?php echo (get_option('healthloft-age_ranges-response-cache')) ? json_encode(get_option('healthloft-age_ranges-response-cache')) : ''; ?></textarea>
            </div>
            <span><strong>Description:</strong> Enter the URL of the API from which health provider data is
                retrieved.</span>
        </div>

        <div class="input-group input-group-sm mb-2">
            <label for="healthloft-age_ranges-response-cache-date">Date:</label>
            <div class="input-group-prepend div-input-group">
                <input type="text" class="col-md-6" id="healthloft-age_ranges-response-cache-date"
                    name="healthloft-age_ranges-response-cache-date"
                    value='<?php echo (get_option('healthloft-age_ranges-response-cache-date')) ? get_option('healthloft-age_ranges-response-cache-date') : ''; ?>'>
            </div>
            <span><strong></strong>Description:</strong> This field shows the date and time of the last update of the
                information. It is for
                informational purposes only and is not editable</span>
        </div>

        <div class="input-group input-group-sm mb-2">
            <label for="healthloft-age_ranges-response-cache-ttl">Ttl<span style="color:red">*</label>:
            <div class="input-group-prepend div-input-group">
                <input type="number" class="col-md-6" id="healthloft-age_ranges-response-cache-ttl"
                    name="healthloft-age_ranges-response-cache-ttl"
                    value='<?php echo (is_numeric(get_option('healthloft-age_ranges-response-cache-ttl')) ? get_option('healthloft-age_ranges-response-cache-ttl') : ''); ?>'
                    required>
            </div>
            <span>
                <strong>Description:</strong> 
                Specifies the time (in seconds) during which the API response is
                considered valid. Adjust
                this value based on how frequently you expect the data to change.
                <br>
                <strong>Example: 18000 (5 hours)</strong> </span>
        </div>
        
        
            <div class="alert alert-warning col-md-6" role="alert" style="display:none">
                The form has been successfully submitted.
            </div>

        <!-- end Age -->
        <button type="submit" class="btn btn-outline-dark mt-2">Submit Form</button>
    </section>
</form>

<?php
}
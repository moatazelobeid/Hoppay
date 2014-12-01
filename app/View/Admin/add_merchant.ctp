<div class="row <?=$menu_title?>"> 
    <div class="large-12 columns page_title">
      <div class="row">
         <div class="large-4 columns ">
           <h4><?=$menu_title?></h4>
        </div>
       <div class="large-8 columns ">        
      </div>
      </div>
      <hr>
    </div>
    <div class="large-12 columns ">
      <div class="row">
        <aside class="large-5 columns large-centered">     
          <form data-abide>
            <fieldset>
                <legend>Website info</legend>
                <div class="url-field">
                    <label>URL <small>required</small>
                      <input type="url" required>
                    </label>
                    <small class="error">An URL is required.</small>
                </div>
                <div class="url-field">
                    <label>Website Name <small>required</small>
                      <input type="text" required>
                    </label>
                    <small class="error">An Website Name is required.</small>
                </div>
            </fieldset>
            <fieldset>
              <legend>Persional information</legend>
              <div class="name-field">
                <label>First name <small>required</small>
                  <input type="text" required pattern="[a-zA-Z]+">
                </label>
                <small class="error">Name is required and must be a string.</small>
              </div>
              <div class="name-field">
                <label>Last name
                  <input type="text" pattern="[a-zA-Z]+">
                </label>
                <small class="error">Name is must be a string.</small>
              </div>
              <div class="email-field">
                <label>Email <small>required</small>
                  <input type="email" required>
                </label>
                <small class="error">An email address is required.</small>
              </div>
              <div class="phon-field">
                <label>Phone <small>required</small>
                  <input type="text" required pattern="alpha_numeric">
                </label>
                <small class="error">An Phone number   is required.</small>
              </div>
              </fieldset>
              <fieldset>
                  <legend>Contact info</legend>
                  <div class="adress1-field">
                    <label>Address1 <small>required</small>
                      <input type="text" required>
                    </label>
                    <small class="error">An Address1  is required.</small>
                  </div>
                  <div class="adress2-field">
                    <label>Address2 
                      <input type="text" >
                    </label>                
                  </div>
                  <div class="city-field">
                    <label>City <small>required</small>
                      <input type="text" required>
                    </label>
                    <small class="error">An City is required.</small>
                  </div>
                  <div class="state-field">
                    <label>State <small>required</small>
                      <input type="text" required>
                    </label>
                    <small class="error">An State is required.</small>
                  </div>
                   <div class="state-field">
                    <label>Country <small>required</small>
                      <input type="text" required>
                    </label>
                    <small class="error">An Country is required.</small>
                  </div>
              </fieldset> 
              <button type="submit" class="right">Submit</button>
          </form>

        </aside>
          <!-- Main Blog Content -->
          <!--<div class="large-7 columns" role="content">
           
          </div>-->
        </div>
    </div>
  </div>
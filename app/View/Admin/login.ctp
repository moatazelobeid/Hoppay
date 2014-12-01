<!--<div class="row">

	<div class="large-3 columns large-centered login" style="margin-top:100px">
		<fieldset>
			<legend>Admin Login</legend>
		<form method="post" action="" data-abide >
		<!--<div class="name-field">
		    <label>
		     	<select name="user_type" requred>
		     		<option value="S">Supper Admin</option>
		     		<option value="A">Adminstrator</option>
		     	</select>
		    </label>
		    <small class="error">Choose Your Admin User type.</small>
		  </div>-->
		 <!-- <div class="name-field">
		    <label>
		      <input type="text" required name="username" placeholder="Username">
		    </label>
		    <small class="error">Enter your Username.</small>
		  </div>
		  <div class="email-field">
		    <label>
		      <input type="password"  name="password" placeholder="Password">
		    </label>
		    <small class="error">Enter your password.</small>
		  </div>
		  <div class="row">
		  	
			<div class="large-5 columns right">
			<input type="submit" name="login" value="login" class="button right">
    		 </div>
			 
			 <div class="large-12 columns" >
					 <$this->Session->flash('bad')?>
					 <$this->Session->flash('msg')?>
			  </div>
		 
		</div>
		</form>
		</fieldset>
	</div>
</div>-->
<!-- Start: login-holder -->
<div id="login-holder">

	<!-- start logo -->
	<div id="logo-login">
		<a href="<?=$this->webroot?>admin"><img src="<?=$this->webroot?>img/logo.png" width="156" height="40" alt="" /></a>
	</div>
	<!-- end logo -->
	
	<div class="clear"></div>
	
	<!--  start loginbox ................................................................................. -->
	<div id="loginbox">
	<?=$this->Session->flash('bad')?>
        <?=$this->Session->flash('msg')?>
	<!--  start login-inner -->
	<div id="login-inner">
		
		
		<form method="post" action=""> 
		<table border="0" cellpadding="0" cellspacing="0">
		<tr>
			<th>Username</th>
			<td><input type="text" name="username" placeholder="Username" class="login-inp" /></td>
		</tr>
		<tr>
			<th>Password</th>
			<td><input type="password" name="password"   value="************"  onfocus="this.value=''" class="login-inp" /></td>
		</tr>
		<tr>
			<th></th>
			<td valign="top"><input  type="checkbox" name="remem_me" class="checkbox-size" value="1" id="login-check" /><label for="login-check">Remember me</label></td>
		</tr>
		<tr>
			<th></th>
			<td><input type="submit" class="submit-login" name="login" /></td>
		</tr>
		</table>
	</form>
	</div>
 	<!--  end login-inner -->
	<div class="clear"></div>
	<a href="" class="forgot-pwd">Forgot Password?</a>
 </div>
 <!--  end loginbox -->
 
	<!--  start forgotbox ................................................................................... -->
	<div id="forgotbox">
		<form method="post" action=""> 
		<div id="forgotbox-text">Please send us your email and we'll reset your password.</div>
		<!--  start forgot-inner -->
		<div id="forgot-inner">
		<table border="0" cellpadding="0" cellspacing="0">
		<tr>
			<th>Email address:</th>
			<td><input type="text" value="" name="email" class="login-inp" /></td>
		</tr>
		<tr>
			<th> </th>
			<td><input type="submit" class="submit-login" name="forgot" /></td>
		</tr>
		</table>
		</div>
		<!--  end forgot-inner -->
		<div class="clear"></div>
		<a href="" class="back-login">Back to login</a>
	    </form>
	</div>
	<!--  end forgotbox -->

</div>
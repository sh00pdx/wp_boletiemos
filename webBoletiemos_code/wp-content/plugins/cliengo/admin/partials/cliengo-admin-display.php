<?php

/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       http://cliengo.com
 * @since      1.0.0
 *
 * @package    Cliengo
 * @subpackage Cliengo/admin/partials
 */
?>
<script type="text/javascript">
    var ajaxurl = "<?php echo admin_url('admin-ajax.php'); ?>";
    var siteUrl = "<?php echo get_site_url(); ?>";
    var userEmail = "<?php echo wp_get_current_user()->user_email; ?>";
    // Get current user first and last name
    var userName = "<?php echo wp_get_current_user()->user_firstname . ' ' . wp_get_current_user()->user_lastname?>";
    // If user doesn't have first or second name configured, reset user name to show input placeholder
    if (userName.trim() === "") userName = null;
</script>
<div id="app" class="cliengo">
	<div class="container" style="margin-top: 5%" v-if="!loading.rendering">
		<div class="row col-lg-12" style="margin-bottom: 20px;">
			<?php echo '<img src="'.plugin_dir_url(__FILE__) . '../images/logo.png'.'" alt="">' ?>
            <a v-if="login.loggedIn" class="link-btn" @click="unlinkAccount()"><?php _e( 'Unlink Account', 'cliengo' ) ?> <i class="fa fa-sign-out logout-icon"></i></a>
		</div>
		<div class="row col-lg-12" v-if="!login.loggedIn">
			<div class="panel">
				<div class="panel-heading">
					<h4><?php _e( 'Do you already have a Cliengo account?', 'cliengo' ) ?></h4>
				</div>
			  	<div class="panel-body">
			  		<div class="radio">
  						<label>
					    	<input type="radio" v-model="option_select" value="true">
					    	<?php _e( 'Yes', 'cliengo' ) ?>
					  	</label>
					</div>
					<div class="radio">
					  	<label>
					    	<input type="radio" v-model="option_select" value="false">
					    	<?php _e( 'No, I want to create one', 'cliengo' ) ?>
					  	</label>
					</div>
				</div>
			</div>

            <!-- Logged out message -->
            <div class="alert alert-dismissable alert-success" role="alert" v-if="messages.loggedOut.success">
                <button type="button" class="close" aria-label="Close" @click="clearMessages()">
                    <span aria-hidden="true">&times;</span>
                </button>
                <i class="fa fa-exclamation-circle" aria-hidden="true"></i>
                <strong>
                  <?php _e( 'Successfully uninstalled Cliengo Chatbot from your site', 'cliengo' ) ?>
                </strong>
            </div>
		</div>
	</div>
	<template v-if="!loading.rendering">
		<div class="container" style="margin-top: 2%" v-if="option_select == 'true' ">
			<div class="row col-lg-12">
                <!-- Log in section -->
				<div class="panel" v-show="!login.loggedIn && !login.tokenInputSelected">
					<div class="panel-heading">
						<h4><?php _e( 'Log into your Cliengo account', 'cliengo' ) ?></h4>
                        <h4 v-show="login.loggedIn"><?php _e( 'Chatbot Configuration', 'cliengo' ) ?></h4>
					</div>
				  	<div class="panel-body">
                        <!-- MESSAGES PANEL -->
                        <div class="alert alert-dismissable" :class="{ 'alert-danger': alertDanger, 'alert-success':alertSuccess }" role="alert" v-show="anyMessage(messages.login)">
                            <button type="button" class="close" aria-label="Close" @click="clearMessages()">
                                <span aria-hidden="true">&times;</span>
                            </button>
                            <strong v-show="messages.login.invalidCredentials">
                                <?php _e( 'Invalid username/password', 'cliengo' ) ?>
                            </strong>
                            <strong v-show="messages.login.otherError">
                                <?php _e( 'Error logging in, please try again', 'cliengo' ) ?>.
                            </strong>
                        </div>
                        <!-- END MESSAGES PANEL -->
                        <!-- LOGIN FORM -->
                        <form class="form-horizontal" @submit="wordPressLogin" action="javascript:void(0);">
                            <div class="row">
                                <label for="email" class="col-md-2 control-label" style="text-align: left;">Email</label>
                                <div class="col-md-5">
                                    <input type="text" placeholder="<?php _e( 'name@somewebsite.com', 'cliengo' ) ?>" name="email" id="email" class="form-control" v-model="login.email" required />
                                </div>
                            </div>
                            <div class="row" style="margin-top: 10px;">
                                <label for="password" class="col-md-2 control-label" style="text-align: left;">Password</label>
                                <div class="col-md-5">
                                    <input type="password" placeholder="<?php _e( '*********', 'cliengo' ) ?>" name="password" id="password" class="form-control" v-model="login.password" required />
                                </div>
                            </div>
                          <p class="social-media-hint"><?php _e( 'Registered through social media? Click <a href="#" @click="login.tokenInputSelected = true">here</a>', 'cliengo' ) ?></p>
                            <button type="submit" class="btn btn-purple" :disabled="loading.login || !login.email || !login.password" style="margin-top: 10px;">
                                <span v-show="!loading.login">
                                    <?php _e( 'Log In', 'cliengo' ) ?>
                                </span>
                                <span v-show="loading.login">
                                    <div class="lds-ellipsis">
                                        <div></div>
                                        <div></div>
                                        <div></div>
                                        <div></div>
                                    </div>
                                </span>
                            </button>
                        </form>
                        <!-- END LOGIN FORM -->
                    </div>
				</div>

                <div class="panel" v-show="!login.loggedIn && login.tokenInputSelected">
                    <div class="panel-heading">
                        <h4><?php _e( 'Provide your token', 'cliengo' ) ?></h4>
                    </div>
                    <div class="panel-body">
                        <div class="alert alert-warning" role="alert">
                            <strong>
                              <?php _e( 'Login at <a href="https://app.cliengo.com/" target="_blank">Cliengo</a> to obtain your chatbot token under Chatbots -> Installation section', 'cliengo' ) ?>
                            </strong>
                        </div>
                        <div :class="{ 'alert':true, 'alert-dismissible':true, 'alert-danger': alertDanger,'alert-success':alertSuccess }" role="alert" v-show="anyMessage(messages.token)">
                            <button type="button" class="close" aria-label="Close" @click="clearMessages()"><span aria-hidden="true">&times;</span></button>
                            <strong v-show="messages.token.tokenValidError">
                              <?php _e( 'Chatbot token entered is incorrect', 'cliengo' ) ?>
                            </strong>
                            <strong v-show="messages.token.tokenUpdateError">
                              <?php _e( 'Chatbot token update failed', 'cliengo' ) ?>
                            </strong>
                        </div>
                        <div class="form-horizontal">
                            <div class="row">
                                <label for="chatbot_token" class="col-md-2 control-label" style="text-align: left;">Chatbot Token:
                                </label>
                                <div class="col-md-5">
                                    <input placeholder="E.g. 5bb7xxxxe4b0xxxxdc03xxxx-5bxxxx12e4bxxxxbdc03xxxx" type="text" name="chatbot_token" id="chatbot_token" class="form-control" v-model="chatbot_token">
                                </div>
                            </div>
                        </div>
                        <a class="btn btn-secondary" @click="login.tokenInputSelected = false"><i class="fa fa-arrow-left back-icon"></i><?php _e( 'Back to Login', 'cliengo' ) ?></a>
                        <button class="btn btn-purple" @click="updateToken()" style="margin-top: 10px;">
                          <?php _e( 'Save changes', 'cliengo' ) ?>
                        </button>
                    </div>
                </div>

                <!-- Logged in section -->
                <div v-if="login.loggedIn">
                    <!-- Account management-->
                    <div class="panel">
                        <div class="panel-heading">
                            <h4><?php _e( 'Account Management', 'cliengo' ) ?></h4>
                        </div>
                        <div class="panel-body">
                            <?php _e( 'At Cliengo, you can manage your clients, customize your chatbots\'s appearance, conversation and automatic responses, integrate with other services and much more!', 'cliengo' ) ?>
                            <br/>
                            <a class="btn btn-purple" style="margin-top:10px" href="https://app.cliengo.com" target="_blank"><?php _e( 'Take me there!', 'cliengo' ) ?><i class="fa fa-external-link icon-right" aria-hidden="true"></i></a>
                        </div>
                    </div>

                    <!-- Chatbot selection  -->
                    <div class="panel" :class="{'cliengo-highlight': highlight}" v-if="!login.disableWebsiteSelector">
                        <div class="panel-heading">
                            <h4><?php _e( 'Chatbot Selection', 'cliengo' ) ?></h4>
                        </div>
                        <div class="panel-body">
                            <?php _e( 'Please select the desired website in order to install the associated chatbot in your site', 'cliengo' ) ?>
                            <!-- CHATBOT SELECTION FORM -->
                            <form class="form-horizontal" @submit="selectWebsite()" action="javascript:void(0);" v-show="login.showConfigForm">
                                <div class="row" style="margin-top: 10px;">
                                    <label for="selectedWebsite" class="col-md-2 control-label" style="text-align: left;">
                                      <?php _e( 'Select a website', 'cliengo' ) ?>
                                    </label>
                                    <div class="col-md-5">
                                        <select id="selectedWebsite" class="form-control" v-model="selectedWebsiteId">
                                            <!-- null matches default app value, otherwise this default option doesn't get selected -->
                                            <option selected disabled value="null">
                                              <?php _e( 'Click to list websites...', 'cliengo' ) ?>
                                            </option>
                                            <option v-for="website in company.websites" :value="website.id">
                                                {{ website.title }} - {{ website.url }}
                                            </option>
                                        </select>
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-purple" :disabled="loading.selectWeb || !selectedWebsiteId" style="margin-top: 10px;">
                                <span v-show="!loading.selectWeb">
                                    <?php _e( 'Install chatbot', 'cliengo' ) ?> <i class="fa fa-plug icon-right" aria-hidden="true"></i>
                                </span>
                                    <span v-show="loading.selectWeb">
                                    <div class="lds-ellipsis">
                                        <div></div>
                                        <div></div>
                                        <div></div>
                                        <div></div>
                                    </div>
                                </span>
                                </button>
                            </form>
                            <!-- END CHATBOT SELECTION FORM -->
                        </div>
                    </div>

                    <!-- Chatbot position -->
                    <div class="panel">
                        <div class="panel-heading">
                            <h4><?php _e( 'Advanced Configuration', 'cliengo' ) ?></h4>
                        </div>
                        <div class="panel-body">
                            <div class="alert alert-warning" role="alert">
                                <strong>
                                  <?php _e( 'This configuration only applies to Chatbot Version 1', 'cliengo' ) ?>
                                </strong>
                            </div>
                            <!-- MESSAGES PANEL -->
                            <div class="alert alert-dismissable alert-success" role="alert" v-if="anyMessage(messages.position)">
                                <button type="button" class="close" aria-label="Close" @click="clearMessages()">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                                <strong>
                                  <?php _e( 'Successfully updated chatbot position!', 'cliengo' ) ?>
                                </strong>
                            </div>
                            <!-- END MESSAGES PANEL -->
                            <!-- CHATBOT CONFIGURATION FORM -->
                            <form class="form-horizontal" @submit="saveChatbotPosition" action="javascript:void(0);" v-show="login.showConfigForm">
                                <div class="row" style="margin-top: 10px;">
                                    <label for="position_chatbot" class="col-md-2 control-label" style="text-align: left;">
                                      <?php _e( 'Chatbot Position', 'cliengo' ) ?>
                                    </label>
                                    <div class="col-md-5">
                                        <select name="position_chatbot" id="position_chatbot" class="form-control" v-model="position_chatbot">
                                            <option value="right">
                                              <?php _e( 'Bottom Right', 'cliengo' ) ?>
                                            </option>
                                            <option value="left">
                                              <?php _e( 'Bottom Left', 'cliengo' ) ?>
                                            </option>
                                        </select>
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-purple" :disabled="loading.chatPos || !position_chatbot" style="margin-top: 10px;">
                                <span v-show="!loading.chatPos">
                                    <?php _e( 'Configure', 'cliengo' ) ?>
                                    <i class="fa fa-cog icon-right" aria-hidden="true"></i>
                                </span>
                                    <span v-show="loading.chatPos">
                                    <div class="lds-ellipsis">
                                        <div></div>
                                        <div></div>
                                        <div></div>
                                        <div></div>
                                    </div>
                                </span>
                                </button>
                            </form>
                            <!-- END CHATBOT CONFIGURATION FORM -->
                        </div>
                    </div>
                </div>
			</div>
		</div>
		<div class="container" style="margin-top: 2%" v-if="option_select == 'false' ">
			<div class="row col-lg-12">
				<div class="panel">
					<div class="panel-heading">
						<h4><?php _e( 'Register in less than a minute and start your <b>free 14-day trial!</b>', 'cliengo' ) ?></h4>
					</div>
                    <div class="panel-body">
                        <!-- Error panel -->
                        <div :class="{ 'alert':true, 'alert-dismissible':true, 'alert-danger': alertDanger,'alert-success':alertSuccess }" role="alert" v-show="anyMessage(messages.reg)">
                            <button type="button" class="close" aria-label="Close" @click="clearMessages()"><span aria-hidden="true">&times;</span></button>
                            <strong v-show="messages.reg.shortPassword">
                              <?php _e( 'You password should have at least 8 characters.', 'cliengo' ) ?>
                            </strong>
                            <strong v-show="messages.reg.invalidWebsite">
                              <?php _e( 'Please provide a valid website. E.g. www.mysite.com', 'cliengo' ) ?>
                            </strong>
                            <strong v-show="messages.reg.missingInfo">
                              <?php _e( 'Please fill out the entire form.', 'cliengo' ) ?>
                            </strong>
                            <strong v-show="messages.reg.serverError">
                                <!-- Show message returned by server -->
                              {{ messages.reg.serverError }}
                            </strong>
                        </div>

                        <!-- Registration form-->
                        <form class="form-horizontal" action="javascript:void(0);">
                            <div class="row">
                                <label for="name" class="col-md-2 control-label" style="text-align: left;"><?php _e( 'Your Name', 'cliengo' ) ?>:
                                </label>
                                <div class="col-md-5">
                                    <input required type="text" placeholder="<?php _e( 'John Doe', 'cliengo' ) ?>" name="name" id="name" class="form-control" v-model="regData.name">
                                </div>
                            </div>
                            <div class="row" style="margin-top: 10px;">
                                <label for="email" class="col-md-2 control-label" style="text-align: left;"><?php _e( 'E-mail', 'cliengo' ) ?>:
                                </label>
                                <div class="col-md-5">
                                    <input required placeholder="<?php _e( 'name@somewebsite.com', 'cliengo' ) ?>" type="email" name="email" id="email" class="form-control" v-model="regData.email">
                                </div>
                            </div>
                            <div class="row" style="margin-top: 10px;">
                                <label for="password" class="col-md-2 control-label" style="text-align: left;"><?php _e( 'Password', 'cliengo' ) ?>:
                                </label>
                                <div class="col-md-5">
                                    <input required placeholder="<?php _e( 'Select a password', 'cliengo' ) ?>" type="password" name="password" id="password" class="form-control" v-model="regData.password">
                                </div>
                            </div>
                            <div class="row" style="margin-top: 10px;">
                                <label for="website" class="col-md-2 control-label" style="text-align: left;"><?php _e( 'Your website', 'cliengo' ) ?>:
                                </label>
                                <div class="col-md-5">
                                    <input id="site-url" required placeholder="<?php _e( 'www.mysite.com', 'cliengo' ) ?>" type="text" name="website" class="form-control" v-model="regData.website">
                                </div>
                            </div>
                            <button class="btn btn-purple" :disabled="loading.reg" @click="registerAndSaveToken()" style="margin-top: 10px;">
                                <span v-show="!loading.reg"><?php _e( 'Register & install Cliengo', 'cliengo' ) ?></span>
                                <span v-show="loading.reg">
                              <div class="lds-ellipsis"><div></div><div></div><div></div><div></div></div>
                            </span>
                            </button>
                        </form>
                    </div>
                </div>
			</div>
		</div>
        <!-- Success modal -->
        <transition name="fade">
            <div class="cliengo-modal" v-if="showModal" @click="closeModal()">
                <div class="cliengo-modal-content" @click="prevent($event)">
                    <span class="close" @click="closeModal()">&times;</span>
                    <h3><?php _e( 'Congratulations! You\'ve successfully installed Cliengo chatbot on your site!', 'cliengo' ) ?></h3>
                  <?php echo '<img src="'.plugin_dir_url(__FILE__) . '../images/chatbot-happy.svg'.'" alt="chatbot installed">' ?>
                    <p>
                      <?php _e( 'You can now go to', 'cliengo' ) ?>
                        <a href="<?php echo get_site_url(); ?>" target="_blank"><?php echo get_site_url(); ?></a>
                      <?php _e( 'and test your site!', 'cliengo' ) ?>
                    </p>
                </div>
            </div>
        </transition>
	</template>
</div>

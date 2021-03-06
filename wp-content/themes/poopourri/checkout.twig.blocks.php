{% block checkout %}


{# BEGIN CHECKOUT TWIG TEMPLATE #}
<!-- ###########################################################################
BEGIN checkout
########################################################################### -->

<!--  *********** fc_checkout_container ************* -->
<div id="fc_checkout_container">{{ html_messages|raw }}
<form id="fc_form_checkout" method="post" action="https://{{ store_domain }}{{ post_url }}" onsubmit="return false;">



    {% block checkout_error %}
    <div id="fc_form_checkout_error" class="fc_error" style="display:none">{{ lang.checkout_required_info_missing|raw }}</div>
    {% endblock checkout_error %}



    {% block required_hidden_fields %}
    <div id="fc_required_hidden_fields">
        <input type="hidden" id="ThisAction" name="ThisAction" value="checkout" />
        <input type="hidden" id="customer_id" name="customer_id" value="{{ customer_id_encoded }}" />
        <input type="hidden" name="{{ session_name }}" value="{{ session_id }}" />
        {{ csrf_hidden_input|raw }}
        {% if auth_token_is_valid %}
            <input type="hidden" name="fc_auth_token" value="{{ fc_auth_token }}" />
            <input type="hidden" name="timestamp" value="{{ timestamp }}" />
            <input type="hidden" name="fc_customer_id" value="{{ fc_customer_id }}" />
        {% endif %}
        {# preserve paypal express variables #}
        {% if token != '' and payer_id != '' %}
            <input type="hidden" id="token" name="token" value="{{ token }}" />
            <input type="hidden" id="PayerID" name="PayerID" value="{{ payer_id }}" />
        {% endif %}
        {% for var_name, var_value in hosted_gateway_vars %}
            <input type="hidden" name="{{ var_name }}" value="{{ var_value }}" />
        {% endfor %}
    </div>
    {% endblock required_hidden_fields %}



    {# NOT DOING THIS
    {% block continue_shopping %}
    <div id="fc_cancel_continue_shopping">
    {% if page_referer != '' and not is_updateinfo %}
        <a href="{{ page_referer }}">{{ lang.checkout_cancel_and_continue|raw }}</a>
    {% endif %}
    </div>
    {% endblock continue_shopping %}
    #}


    {% block noscript_warning %}
    <noscript>
        <div id="fc_error_noscript" class="fc_error">
            <h3>{{ lang.checkout_warning|raw }}</h3>
            <p>{{ lang.checkout_missing_message|raw }}</p>
        </div><!-- #fc_errorNoScript -->
    </noscript>
    {% endblock noscript_warning %}



    {% block login_register %}
    <!--  *********** login_register : Login or Register ************* -->
    <div class="fc_fieldset_container" id="fc_login_register_container">
    <h2 id="your_email_address" style="margin-top:30px;"><span class="screen-reader-text">Your Email Address For Shipment Confirmation</span></h2>
    <fieldset id="fc_login_register" class="white-checkout-box">
        <legend>{% if checkout_type == 'guest_only' %}{{ lang.checkout_as_guest|raw }}{% else %}{{ lang.checkout_login_or_register|raw }}{% endif %}</legend>
        <div class="fc_inner">
            <ol id="fc_login_register_list">
        {% if not customer_is_authenticated %}
                <li id="li_customer_email" class="fc_row fc_customer_email">
                    <label class="fc_pre" for="customer_email">{{ lang.checkout_email|raw }}<span class="fc_ast">*</span></label>
                    <input type="text" value="{{ email }}" autocomplete="off" class="fc_text fc_text_long fc_required" id="customer_email" name="customer_email">
                    <label style="display:none;" class="fc_error" for="customer_email">{{ lang.checkout_error_email|raw }}</label>
                    <p class="fc_account_message" id="fc_account_message_status">
                        {{ lang.checkout_instructions_email|raw }}
                    </p>
                    <span style="display:none" id="login_ajax"><img alt="{{ lang.checkout_loading|raw }}" src="//cdn.foxycart.com/static{{ base_directory }}/images/ajax-loader.gif?ver=1"></span>
                    <p style="display:none;" class="fc_account_message" id="fc_account_message_explanation"></p>
                </li>
            {% if not is_updateinfo and checkout_type != 'guest_only' and checkout_type != 'account_only' %} 
                <li class="fc_row fc_row_radio fc_guest_checkout">
                    <label for="is_anonymous_1" class="fc_radio">
                        <input type="radio" name="is_anonymous" value="1" id="is_anonymous_1" class="fc_radio"{% if default_to_guest %} checked="checked"{% endif %} autocomplete="off"/>
                        <span>{{ lang.checkout_as_guest|raw }}</span>
                    </label>
                </li>
                <li class="fc_row fc_row_radio fc_guest_checkout">
                    <label for="is_anonymous_0" class="fc_radio">
                        <input type="radio" name="is_anonymous" value="0" id="is_anonymous_0" class="fc_radio"{% if not default_to_guest %} checked="checked"{% endif %} autocomplete="off" />
                        <span>{{ lang.checkout_as_customer|raw }}</span>
                    </label>
                </li>
            {% else %}
                {% if checkout_type == 'guest_only' %}
                    <input type="hidden" name="is_anonymous" id="is_anonymous" value="1" />
                {% else %}
                    <input type="hidden" name="is_anonymous" id="is_anonymous" value="0" />
                {% endif %}
            {% endif %}
        {% else %}
                <li class="fc_row fc_customer_email" id="li_customer_email">
                    <span class="fc_pre">{{ lang.checkout_email|raw }}<span class="fc_ast">*</span></span>
                    <span id="customer_email_authenticated" class="fc_text">{{ email }}</span>
                    <input type="hidden" name="customer_email" id="customer_email" value="{{ email }}" />
                    <label for="customer_email" class="fc_error" style="display:none;">{{ lang.checkout_error_email|raw }}</label>
                    <p id="fc_account_message_sso" class="fc_account_message">{{ lang.checkout_sso_already_logged_in|raw }}</p
                </li>
        {% endif %}
                <li id="li_customer_password" style="display:none;" class="fc_row fc_customer_password">
                    <p style="display:none;" class="fc_account_message" id="fc_account_message_password"></p>
                    <label class="fc_pre" for="customer_password">{{ lang.checkout_password|raw }}</label>
                    <input type="password" value="{{ customer_password }}" autocomplete="off" class="fc_text fc_text_long" id="customer_password" name="customer_password">
                    <label style="display:none;" class="fc_error" for="customer_password">{{ lang.checkout_error_password|raw }}</label>
                </li>
                <li id="li_customer_password2" style="display:none;" class="fc_row fc_customer_password2">
                    <label class="fc_pre" for="customer_password2">{{ lang.checkout_retype_password|raw }}</label>
                    <input type="password" value="{{ customer_password }}" autocomplete="off" class="fc_text fc_text_long" onchange="FC.checkout.checkPasswords()" id="customer_password2" name="customer_password2">
                    <label style="display:none;" class="fc_error" for="customer_password2">{{ lang.checkout_error_retype_password|raw }}</label>
                </li>
                <li id="li_customer_email_password" class="fc_row" style="display:none">
                    <label for="fc_email_password" class="fc_error"><a id="fc_email_password" href="javascript:;" onclick="FC.checkout.emailPassword()">{{ lang.checkout_email_my_password|raw }}</a></label>
                </li>
                <li id="li_customer_new_password" class="fc_row" style="display:none">
                    <label for="fc_new_password"><a id="fc_new_password" href="javascript:;" onclick="FC.checkout.newPassword()">{{ lang.checkout_change_my_password|raw }}</a></label>
                </li>
            </ol>
            <input type="hidden" name="email_found" id="email_found" value="{{ email_found }}" />
            <div id="fc_continue" class="fc_row fc_row_actions"><button type="button" onclick="FC.checkout.checkLogin(); return false;" class="fc_link_nav fc_link_forward">{{ lang.checkout_continue|raw }}</button></div>
            <span class="fc_clear">&nbsp;</span>
        </div><!-- .fc_inner -->
    </fieldset><!-- #fc_login_register -->
    <span class="fc_clear">&nbsp;</span>
    </div><!-- #fc_login_register_container -->
    {% endblock login_register %}




    {% if not is_subscription_cancel %}
    <div id="fc_data_entry_container">
        <div id="fc_customer_info_container">



            {% block customer_shipping %}
            <!--  *********** address_shipping : Shipping Address ************* -->
            <div class="fc_fieldset_container" id="fc_address_shipping_container">
                 <h2 id="where_should_we_ship"><span class="screen-reader-text">Where Should We Ship Your Order?</span></h2>
                <fieldset id="fc_shipping_address" class="white-checkout-box">
                    <legend>{{ lang.checkout_shipping_address|raw }}</legend>
                    <div class="fc_inner">
                        <ol id="fc_address_shipping_list">
                            <li class="fc_row fc_shipping_first_name fc_shipping_last_name">
                                <label class="fc_pre" for="shipping_first_name">Name<span class="fc_ast">*</span></label>
                                <input type="text" value="{{ shipping_first_name }}" class="fc_text fc_text_short fc_required" id="shipping_first_name" placeholder="First" name="shipping_first_name" autocomplete="shipping given-name">
                                <input type="text" value="{{ shipping_last_name }}" class="fc_text fc_text_short fc_required" id="shipping_last_name" placeholder="Last" name="shipping_last_name" autocomplete="shipping family-name">
                                <label style="display:none;" class="fc_error" for="shipping_first_name">{{ lang.checkout_error_first_name|raw }}</label>
                                <label style="display:none;" class="fc_error" for="shipping_last_name">{{ lang.checkout_error_last_name|raw }}</label>
                            </li>
                            <li class="fc_row fc_shipping_company" style="display: none">
                                <label class="fc_pre" for="shipping_company">{{ lang.checkout_company|raw }}</label>
                                <input type="text" value="{{ shipping_company }}" class="fc_text fc_text_long" id="shipping_company" name="shipping_company" autocomplete="shipping organization">
                                <label style="display:none;" class="fc_error" for="shipping_company">{{ lang.checkout_error_company|raw }}</label>
                            </li>
                            <li class="fc_row fc_shipping_address1">
                                <label class="fc_pre" for="shipping_address1">{{ lang.checkout_address1|raw }}<span class="fc_ast">*</span></label>
                                <input type="text" value="{{ shipping_address1 }}" class="fc_text fc_text_long fc_required" id="shipping_address1" name="shipping_address1" autocomplete="shipping address-line1">
                                <label style="display:none;" class="fc_error" for="shipping_address1">{{ lang.checkout_error_address1|raw }}</label>
                            </li>
                            <li class="fc_row fc_shipping_address2">
                                <label class="fc_pre" for="shipping_address2">{{ lang.checkout_address2|raw }}</label>
                                <input type="text" value="{{ shipping_address2 }}" class="fc_text fc_text_long" id="shipping_address2" name="shipping_address2" autocomplete="shipping address-line2">
                            </li>
                            <li class="fc_row fc_shipping_city">
                                <label class="fc_pre" for="shipping_city">{{ lang.checkout_city|raw }}<span class="fc_ast">*</span></label>
                                <input type="text" value="{{ shipping_city }}" class="fc_text fc_text_long fc_required" id="shipping_city" name="shipping_city" autocomplete="shipping locality">
                                <label style="display:none;" class="fc_error" for="shipping_city">{{ lang.checkout_error_city|raw }}</label>
                            </li>
                            <li class="fc_row fc_row_select fc_foxycomplete fc_shipping_state_name">
                                <label class="fc_pre" for="shipping_state_name">{{ lang.checkout_state|raw }}<span class="fc_ast">*</span></label>
                                <select class="fc_text fc_text_long fc_required fc_location" data-default-value="{{ shipping_region_code }}" id="shipping_state" name="shipping_state">
                                {{ shipping_region_options|raw }}
                                </select>
                                <input value="{{ (shipping_region_code == '') ? shipping_region_name : shipping_region_code }}" type="text" style="display:none;" class="fc_foxycomplete_input fc_text fc_text_long fc_required fc_location" id="shipping_state_name" name="shipping_state_name">
                                <label style="display:none;" class="fc_error" for="shipping_state_name">{{ lang.checkout_error_state|raw }}</label>
                            </li>
                                <li class="fc_row fc_shipping_postal_code">
                                <label class="fc_pre" for="shipping_postal_code">{{ lang.checkout_postal_code|raw }}<span class="fc_ast">*</span></label>
                                <input type="text" value="{{ shipping_postal_code }}" class="fc_text fc_text_short fc_required" id="shipping_postal_code" name="shipping_postal_code" autocomplete="shipping postal-code">
                                <label style="display:none;" class="fc_error" for="shipping_postal_code">{{ lang.checkout_error_postal_code|raw }}</label>
                                <label style="display:none;" class="fc_error fc_error_invalid_postal_code" for="shipping_postal_code">{{ lang.checkout_error_invalid_postal_code|raw }}</label>
                            </li>
                            <li class="fc_row fc_shipping_phone">
                                <label class="fc_pre" for="shipping_phone">{{ lang.checkout_phone|raw }}</label>
                                <input type="text" value="{{ shipping_phone }}" class="fc_text fc_text_long" id="shipping_phone" name="shipping_phone" autocomplete="shipping tel">
                                <label style="display:none;" class="fc_error" for="shipping_phone">{{ lang.checkout_error_phone|raw }}</label>
                            </li>
                            <li class="fc_row fc_row_select fc_foxycomplete fc_shipping_country_name">
                                <label class="fc_pre" for="shipping_country_name">{{ lang.checkout_country|raw }}<span class="fc_ast">*</span></label>
                                <select class="fc_text fc_text_long fc_required fc_location" data-default-value="{{ country_code }}" id="shipping_country" name="shipping_country">
                                {{ shipping_country_options|raw }}
                                </select>
                                <input value="{{ (shipping_country_code == '') ? shipping_country_name : shipping_country_code }}" type="text" style="display:none;" class="fc_foxycomplete_input fc_text fc_text_long fc_required fc_location" id="shipping_country_name" name="shipping_country_name">
                                <label style="display:none;" class="fc_error" for="shipping_country_name">{{ lang.checkout_error_country|raw }}</label>
                            </li>
                            <li class="fc_row fc_shipping_country_change">
                                <label class="fc_pre"></label>
                                <span id="current_shipping_country">{{ shipping_country_name }}</span> <a href="#" id="change_shipping_country">Change country</a>
                            </li>
                        </ol>
                        <span class="fc_clear">&nbsp;</span>
                    </div><!-- .fc_inner -->
                </fieldset><!-- #fc_address_shipping -->
                <span class="fc_clear">&nbsp;</span>
            </div>

            {% set use_different_billing_address = first_name and first_name != shipping_first_name ? 1 : 0 %}



           <div class="fc_row fc_row_checkbox" id="fc_different_billing_address">
                <label class="fc_checkbox" for="different_billing_address">
                    <input type="checkbox" class="checkbox" value="1" id="different_billing_address"{{ use_different_billing_address ? ' checked="checked"' }}>
                    <span>My credit card billing address is different from my shipping address</span>
                </label>
            </div>

            {% endblock customer_shipping %}




        {% block customer_billing %}
            <!--  *********** customer_billing : Billing Address ************* -->
            <div class="fc_fieldset_container" id="fc_customer_billing_container"{{ not use_different_billing_address ? ' style="display: none;"' }}>
                <h2 id="credit_card_billing_address"><span class="screen-reader-text">Credit Card Billing Address</span></h2>
                <fieldset id="fc_customer_billing" class="white-checkout-box">
                    <legend>{{ lang.checkout_billing_address|raw }}</legend>
                    <div class="fc_inner">
                        <ol id="fc_customer_billing_list">
                            <li class="fc_row fc_customer_first_name">
                                <label class="fc_pre" for="customer_first_name fc_customer_last_name">Name<span class="fc_ast">*</span></label>
                                <input type="text" value="{{ first_name }}" class="fc_text fc_text_short fc_required" id="customer_first_name" name="customer_first_name" placeholder="First" autocomplete="billing given-name">
                                <input type="text" value="{{ last_name }}" class="fc_text fc_text_short fc_required" id="customer_last_name" name="customer_last_name" placeholder="Last" autocomplete="billing family-name">
                                <label style="display:none;" class="fc_error" for="customer_first_name">{{ lang.checkout_error_first_name|raw }}</label>
                                <label style="display:none;" class="fc_error" for="customer_last_name">{{ lang.checkout_error_last_name|raw }}</label>
                            </li>
                            <li class="fc_row fc_customer_company" style="display: none;">
                                <label class="fc_pre" for="customer_company">{{ lang.checkout_company|raw }}</label>
                                <input type="text" value="{{ company }}" class="fc_text fc_text_long" id="customer_company" name="customer_company" autocomplete="billing organization">
                                <label style="display:none;" class="fc_error" for="customer_company">{{ lang.checkout_error_company|raw }}</label>
                            </li>
                            <li class="fc_row fc_customer_address1">
                                <label class="fc_pre" for="customer_address1">{{ lang.checkout_address1|raw }}<span class="fc_ast">*</span></label>
                                <input type="text" value="{{ address1 }}" class="fc_text fc_text_long fc_required" id="customer_address1" name="customer_address1" autocomplete="billing address-line1">
                                <label style="display:none;" class="fc_error" for="customer_address1">{{ lang.checkout_error_address1|raw }}</label>
                            </li>
                            <li class="fc_row fc_customer_address2">
                                <label class="fc_pre" for="customer_address2">{{ lang.checkout_address2|raw }}</label>
                                <input type="text" value="{{ address2 }}" class="fc_text fc_text_long" id="customer_address2" name="customer_address2" autocomplete="billing address-line2">
                            </li>
                            <li class="fc_row fc_customer_city">
                                <label class="fc_pre" for="customer_city">{{ lang.checkout_city|raw }}<span class="fc_ast">*</span></label>
                                <input type="text" value="{{ city }}" class="fc_text fc_text_long fc_required" id="customer_city" name="customer_city" autocomplete="billing locality">
                                <label style="display:none;" class="fc_error" for="customer_city">{{ lang.checkout_error_city|raw }}</label>
                            </li>
                            <li class="fc_row fc_row_select fc_foxycomplete fc_customer_state_name">
                                <label class="fc_pre" for="customer_state_name">{{ lang.checkout_state|raw }}<span class="fc_ast">*</span></label>
                                <select class="fc_text fc_text_long fc_required fc_location" data-default-value="{{ region_code }}" id="customer_state" name="customer_state">
                                {{ region_options|raw }}
                                </select>
                                <input value="{{ (region_code == '') ? region_name : region_code }}" type="text" style="display:none;" class="fc_foxycomplete_input fc_text fc_text_long fc_required fc_location" id="customer_state_name" name="customer_state_name">
                                <label style="display:none;" class="fc_error" for="customer_state_name">{{ lang.checkout_error_state|raw }}</label>
                            </li>
                                <li class="fc_row fc_customer_postal_code">
                                <label class="fc_pre" for="customer_postal_code">{{ lang.checkout_postal_code|raw }}<span class="fc_ast">*</span></label>
                                <input type="text" value="{{ postal_code }}" class="fc_text fc_text_short fc_required" id="customer_postal_code" name="customer_postal_code" autocomplete="billing postal-code">
                                <label style="display:none;" class="fc_error" for="customer_postal_code">{{ lang.checkout_error_postal_code|raw }}</label>
                                <label style="display:none;" class="fc_error fc_error_invalid_postal_code" for="customer_postal_code">{{ lang.checkout_error_invalid_postal_code|raw }}</label>
                            </li>
                            <li class="fc_row fc_customer_phone">
                                <label class="fc_pre" for="customer_phone">{{ lang.checkout_phone|raw }}</label>
                                <input type="text" value="{{ phone }}" class="fc_text fc_text_long" id="customer_phone" name="customer_phone" autocomplete="billing tel">
                                <label style="display:none;" class="fc_error" for="customer_phone">{{ lang.checkout_error_phone|raw }}</label>
                            </li>
                            <li class="fc_row fc_row_select fc_foxycomplete fc_customer_country_name">
                                <label class="fc_pre" for="customer_country_name">{{ lang.checkout_country|raw }}<span class="fc_ast">*</span></label>
                                <select class="fc_text fc_text_long fc_required fc_location" data-default-value="{{ country_code }}" id="customer_country" name="customer_country">
                                {{ country_options|raw }}
                                </select>
                                <input value="{{ (country_code == '') ? country_name : country_code }}" type="text" style="display:none;" class="fc_foxycomplete_input fc_text fc_text_long fc_required fc_location" id="customer_country_name" name="customer_country_name">
                                <label style="display:none;" class="fc_error" for="customer_country_name">{{ lang.checkout_error_country|raw }}</label>
                            </li>
                            <li class="fc_row fc_customer_country_change">
                                <label class="fc_pre"></label>
                                <span id="current_customer_country">{{ country_name }}</span> <a href="#" id="change_customer_country">Change</a>
                            </li>
                        </ol>
                        <span class="fc_clear">&nbsp;</span>
                    </div><!-- .fc_inner -->
                </fieldset><!-- #fc_customer_billing -->
                <span class="fc_clear">&nbsp;</span>
            </div>
            <input checked="checked" type="checkbox" onclick="FC.checkout.displayShippingAddress(this)" class="checkbox" value="1" id="use_different_addresses" name="use_different_addresses" style="display: none;">

        {% endblock customer_billing %}


        </div><!-- #fc_customer_info_container -->

        {# This place holder is here for backward compatibility so that custom fields will be injected into the correct place. #}
        ^^custom_fields^^


    {% block checkout_shipping_and_summary %}
        <!--  *********** shipping : Delivery &amp; Subtotal ************* -->
        <div id="fc_shipping_container" class="fc_fieldset_container"{% if is_updateinfo %} style="display:none;"{% endif %}>
            <h2 id="checkout_delivery_subtotal"><span class="screen-reader-text">{{ lang.checkout_delivery_and_subtotal|raw }}</span></h2>
            <fieldset id="fc_shipping" class="white-checkout-box">
                <legend>{{ lang.checkout_delivery_and_subtotal|raw }}</legend>
                <div class="fc_inner">
                {% if has_live_rate_shippable_products and not has_multiship %}
                    <div id="fc_shipping_methods_container" class="fc_row fc_shipping_methods_container">
                        <label for="fc_shipping_methods" class="fc_pre fc_shipping_methods">{{ lang.checkout_shipping_methods|raw }}</label>
                        <div id="fc_shipping_methods" class="fc_radio_group_container fc_row fc_shipping_methods">
                            <div id="fc_shipping_result" class="fc_shipping_result">{{ lang.checkout_update_shipping_message|raw }}</div>
                            <span id="shipping_ajax" class="fc_shipping_ajax" style="display:none">{{ lang.checkout_updating_shipping_options|raw }}<img src="//cdn.foxycart.com/static{{ base_directory }}/images/ajax-loader.gif?ver=1" alt="{{ lang.checkout_loading|raw }}" /></span>
                            <textarea rows="1" cols="1" name="shipping_options" id="shipping_options" style="display:none;">{{ shipping_options }}</textarea>
                            <input type="hidden" name="shipping_service_id" id="shipping_service_id" value="{{ shipping_service_id }}" />
                            <input type="hidden" name="shipping_service_description" id="shipping_service_description" value="{{ shipping_service_description }}" />
                            <div id="fc_shipping_methods_inner" class="fc_shipping_methods_inner">
                                {{ shipping_options_html|raw }}
                            </div>
                            <label for="fc_shipping_methods" class="fc_error" style="display:none">{{ lang.checkout_select_shipping_option|raw }}</label>
                        </div>
                    </div>
                {% endif %}
                {% if has_downloadables %}
                    <div class="fc_downloadable_message_container">
                        <p class="fc_downloadable_message">{{ lang.checkout_downloadables_message|raw }}</p>
                    </div>
                {% endif %}
                    <ol id="fc_shipping_list">
                        <li class="fc_row fc_subtotal">
                            <label for="subtotal" class="fc_pre">{{ lang.checkout_cart_subtotal|raw }}</label>
                            <span id="subtotal_formatted" class="fc_text">{{ checkout_subtotal|money_format }}</span>
                            <input value="{{ checkout_subtotal }}" type="hidden" name="subtotal" id="subtotal" />
                        </li>
                    {% if has_future_products %}
                        <li class="fc_row fc_future_subscriptions">
                            <label for="future_subscriptions" class="fc_pre">{{ lang.cart_future_subscriptions|raw }}</label>
                            <span id="future_subscriptions_formatted" class="fc_text">{{ checkout_future_subscriptions|money_format }}</span>
                            <input value="{{ checkout_future_subscriptions }}" type="hidden" name="future_subscriptions" id="future_subscriptions" />
                        </li>
                    {% endif %}
                {% if has_shipping_or_handling_cost %}
                        <li class="fc_row fc_shipping_cost">
                            <label for="shipping_cost" class="fc_pre">Shipping</label>
                            <span id="shipping_cost_formatted" class="fc_text">{{ checkout_shipping_cost|money_format }}</span>
                            <input value="{{ checkout_shipping_cost }}" type="hidden" name="shipping_cost" id="shipping_cost" />
                        </li>
                    {% if has_future_products %}
                        <li class="fc_row fc_future_shipping_cost"{% if not has_future_shipping_and_handling %} style="display:none;"{% endif %}>
                            <label for="future_shipping_cost" class="fc_pre">{{ lang.cart_future_subscriptions|raw }} Shipping</label>
                            <span id="future_shipping_cost_formatted" class="fc_text">{{ checkout_future_shipping_cost|money_format }}</span>
                            <input value="{{ checkout_future_shipping_cost }}" type="hidden" name="future_shipping_cost" id="future_shipping_cost" />
                        </li>
                    {% endif %}
                {% endif %}
                    {% if has_discount %}
                        <li class="fc_row fc_discount">
                            <label for="discount" class="fc_pre">{{ lang.checkout_discount|raw }}</label>
                            <span id="discount_formatted" class="fc_text">{{ checkout_discount|money_format }}</span>
                            <input value="{{ checkout_discount }}" type="hidden" name="discount" id="discount" />
                        </li>
                    {% endif %}
                        <li class="fc_row fc_tax">
                            <label for="tax" class="fc_pre">{{ lang.checkout_tax|raw }}</label>
                            <span id="tax_formatted" class="fc_text">{{ checkout_tax|money_format }}</span>
                            <input value="{{ checkout_tax }}" type="hidden" name="tax" id="tax" />
                        </li>
                        <li class="fc_row fc_order_total">
                            <label for="order_total" class="fc_pre">{{ lang.checkout_order_total|raw }}</label>
                            <span id="order_total_formatted" class="fc_text">{{ checkout_order_total|money_format }}</span>
                            <input value="{{ checkout_order_total }}" type="hidden" name="order_total" id="order_total" />
                        </li>
                    </ol>
                    <span class="fc_clear">&nbsp;</span>
                </div><!-- .fc_inner -->
            </fieldset><!-- #fc_shipping -->
            <span class="fc_clear">&nbsp;</span>
        </div><!-- #fc_shipping_container -->
    {% endblock checkout_shipping_and_summary %}



    {% block checkout_payment %}
        <!--  *********** payment : Payment Information ************* -->
        <div id="fc_payment_container" class="fc_fieldset_container ">
            <h2 id="checkout_payment_information"><span class="screen-reader-text">{{ lang.checkout_payment_information|raw }}</span></h2>
            <fieldset id="fc_payment" class="secure-payment-checkout">
                <legend>{{ lang.checkout_payment_information|raw }}</legend>
                <div class="fc_inner" style="position:relative;">
                    <ol id="fc_payment_list">
                    {% if supports_pay_with_plastic %}
                        <li id="fc_payment_method_plastic_container" class="fc_row fc_row_payment_method">
                            <label for="fc_payment_method_plastic" class="fc_radio">
                                <input type="{{ payment_method_input_type }}"{% if payment_method_type == 'plastic' %} checked="checked"{% endif %} name="fc_payment_method" id="fc_payment_method_plastic" class="fc_radio" value="plastic" autocomplete="off" />
                                <img src="<?php bloginfo("stylesheet_directory"); ?>/images/credit_cards.png" title="We accept all major credit cards">
                            </label>
                        {% if has_multiple_payment_options %}
                            <fieldset>
                                <ol>
                        {% else %}
                            </li>
                        {% endif %}{# has_multiple_payment_options #}
                                    <li id="li_cc_saved" class="fc_row fc_row_radio">
                                        <label for="c_card_saved" class="fc_radio">
                                            <input{% if cc_card_is_saved %} checked="checked"{% endif %} type="radio" name="c_card" value="saved" id="c_card_saved" class="fc_radio" onclick="FC.checkout.displayNewCC(0)" autocomplete="off" />
                                            <span>{{ lang.checkout_use_saved_payment_info|raw }}</span>
                                            <span id="fc_c_card_saved_number">{{ checkout_cc_number_masked }}</span>
                                        </label>
                                    </li>
                                    <li id="li_cc_new" class="fc_row fc_row_radio">
                                        <label for="c_card_new" class="fc_radio">
                                            <input{% if not cc_card_is_saved %} checked="checked"{% endif %} type="radio" name="c_card" value="new" id="c_card_new" class="fc_radio" onclick="FC.checkout.displayNewCC(1)" autocomplete="off" />
                                            <span>{{ lang.checkout_enter_new_card|raw }}</span>
                                        </label>
                                    </li>
                                    <li id="li_cc_number" class="fc_row li_cc_number">
                                        <label for="cc_number" class="fc_pre">{{ lang.checkout_card_number|raw }}</label>
                                        <input type="text" name="cc_number" id="cc_number" class="fc_text fc_text_long fc_required" autocomplete="off" value="{{ cc_number }}"  placeholder="&bull;&bull;&bull;&bull; &bull;&bull;&bull;&bull; &bull;&bull;&bull;&bull; &bull;&bull;&bull;&bull;" />
                                        <label for="cc_number" class="fc_error" style="display:none">{{ lang.checkout_error_card_number|raw }}</label>
                                    </li>
                                    <li id="li_cc_issue_number" class="fc_row">

                                        <label for="cc_issue_number" class="fc_pre">
                                            {{ lang.checkout_issue_number|raw }}
                                        </label>
                                        <input value="{{ cc_issue_number }}" type="text" name="cc_issue_number" id="cc_issue_number" class="fc_text fc_text_short fc_required" maxlength="2" />
                                        <label for="cc_issue_number" class="fc_error" style="display:none">{{ lang.checkout_error_issue_number|raw }}</label>
                                    </li>
                                    <li id="li_cc_start_date_month" class="fc_row">
                                        <label for="cc_start_date_month" class="fc_pre">{{ lang.checkout_start_date|raw }}</label>
                                        <select id="cc_start_date_month" name="cc_start_date_month" class="inline select_mo">
                                            <option value="">{{ lang.cart_month|raw }}</option>
                                            {{ cc_start_date_month_options|raw }}
                                        </select>
                                        <select id="cc_start_date_year" name="cc_start_date_year" class="inline select_yr">
                                            <option value="">{{ lang.cart_year|raw }}</option>
                                            {{ cc_start_date_year_options|raw }}
                                        </select>
                                        <label for="cc_start_date_month" class="fc_error" style="display:none">{{ lang.checkout_error_start_date|raw }}</label>
                                    </li>
                                    <li id="li_cc_exp_month" class="fc_row">
                                        <label for="cc_exp_month" class="fc_pre">{{ lang.checkout_expiration|raw }}</label>
                                        <select id="cc_exp_month" name="cc_exp_month" class="inline select_mo">
                                            <option value="">{{ lang.cart_month|raw }}</option>
                                            {{ cc_expiration_month_options|raw }}
                                        </select>
                                        <select id="cc_exp_year" name="cc_exp_year" class="inline select_yr">
                                            <option value="">{{ lang.cart_year|raw }}</option>
                                            {{ cc_expiration_year_options|raw }}
                                        </select>
                                        <label for="cc_exp_month" class="fc_error" style="display:none">{{ lang.checkout_error_expiration|raw }}</label>
                                    </li>

                                    <li id="li_cc_cvv2" class="fc_row li_cc_cvv2">
                                        <label for="cc_cvv2" class="fc_pre">
                                            {{ lang.checkout_verification_code|raw }}
                                            <span id="fc_help_cvv2" class="fc_help">(<a id="fc_help_cvv2_link" class="fc_help fc_jTip" href="https://{{ store_domain }}{{ base_directory }}/checkout.help.php?topic=cvv2&amp;width=308">{{ lang.checkout_question_mark|raw }}</a>)</span>
                                        </label>
                                        <input value="{{ cc_cvv2 }}" type="text" name="cc_cvv2" id="cc_cvv2" autocomplete="off" class="fc_text fc_text_short fc_required" maxlength="4" />
                                        <label for="cc_cvv2" class="fc_error" style="display:none">{{ lang.checkout_error_verification_code|raw }}</label>
                                    </li>

                                    <li id="li_save_cc" class="fc_row fc_row_checkbox">
                                        <label for="save_cc" class="fc_checkbox">
                                            <input{% if save_cc_is_checked %} checked="checked"{% endif %} type="checkbox" name="save_cc" id="save_cc" value="1" class="fc_checkbox" />
                                            <span>{{ save_cc_text }}</span>
                                        </label>
                                        <label for="save_cc" class="fc_error" style="display:none">{{ lang.checkout_error_subscription_permission|raw }}</label>
                                        <input type="hidden" name="cc_number_masked" id="cc_number_masked" value="{{ checkout_cc_number_masked }}" />
                                    </li>
                        {% if has_multiple_payment_options %}
                                </ol>
                            </fieldset>
                        </li>
                        {% endif %}{# has_multiple_payment_options #}
                    {% endif %}{# supports_pay_with_plastic #}

                    {% if supports_paypal_express and not is_updateinfo %}
                        <li id="fc_payment_method_paypal_container" class="fc_row fc_row_payment_method">
                        {% if has_multiple_payment_options %}
                            <label for="fc_payment_method_paypal" class="fc_radio">
                                <input type="{{ payment_method_input_type }}"{% if payment_method_type == 'paypal' %} checked="checked"{% endif %} name="fc_payment_method" id="fc_payment_method_paypal" class="fc_radio" value="paypal" autocomplete="off" />
                                <span>{{ lang.checkout_pay_with_paypal|raw }}</span>
                            </label>
                        {% else %}
                            <input type="hidden" name="fc_payment_method" id="fc_payment_method" value="paypal" />
                            <span>{{ lang.checkout_pay_with_paypal|raw }}</span>
                        {% endif %}
                            <fieldset>
                                <p>{{ paypal_description|raw }}</p>
                            </fieldset>
                        </li>
                    {% endif %}{# supports_paypal_express and not is_updateinfo #}

                    {% if not is_updateinfo %}
                    {% for hosted_gateway in hosted_payment_gateways %}
                        <li id="fc_payment_method_{{ hosted_gateway.type }}_container" class="fc_row fc_row_payment_method fc_row_hosted_payment_method">
                        {% if has_multiple_payment_options %}
                            <label class="fc_radio">
                                <input type="{{ payment_method_input_type }}"{% if payment_method_type == hosted_gateway.type %} checked="checked"{% endif %} name="fc_payment_method" id="fc_payment_method_{{ hosted_gateway.type }}" class="fc_radio" value="{{ hosted_gateway.type }}" autocomplete="off" />
                                <span>{{ hosted_gateway.lang_pay_with|raw }}</span>
                            </label>
                        {% else %}
                            <input type="hidden" name="fc_payment_method" id="fc_payment_method_{{ hosted_gateway.type }}" value="{{ hosted_gateway.type }}" />
                            <span>{{ hosted_gateway.lang_pay_with|raw }}</span>
                        {% endif %}
                            <fieldset>
                                <p>{{ hosted_gateway.lang_payment_method|raw }}</p>
                            </fieldset>
                        </li>
                    {% endfor %}
                    {% endif %}{# not is_updateinfo #}

                    {% if supports_purchase_order and not is_updateinfo %}
                        <li id="fc_payment_method_purchase_order_container" class="fc_row fc_row_payment_method">
                            <label for="fc_payment_method_purchase_order" class="fc_radio">
                                <input type="{{ payment_method_input_type }}"{% if payment_method_type == 'purchase_order' %} checked="checked"{% endif %} name="fc_payment_method" id="fc_payment_method_purchase_order" class="fc_radio" value="purchase_order" autocomplete="off" />
                                <span>{{ lang.checkout_pay_with_purchase_order|raw }}</span>
                            </label>
                        {% if has_multiple_payment_options %}
                            <fieldset>
                                <ol>
                        {% else %}
                        </li>
                        {% endif %}{# has_multiple_payment_options #}
                                    <li id="li_purchase_order" class="fc_row li_purchase_order">
                                        <label for="purchase_order" class="fc_pre">
                                            {{ lang.checkout_purchase_order_number|raw }}
                                        </label>
                                        <input value="{{ purchase_order }}" type="text" name="purchase_order" id="purchase_order" class="fc_text fc_required" />
                                        <label for="purchase_order" class="fc_error" style="display:none">{{ lang.checkout_error_purchase_order|raw }}</label>
                                    </li>
                        {% if has_multiple_payment_options %}
                                </ol>
                            </fieldset>
                        </li>
                        {% endif %}{# has_multiple_payment_options #}
                    {% endif %}{# supports_purchase_order and not is_updateinfo #}

                        <li id="li_nopayment" class="fc_row">
                            {# This is used for $0 transactions and other situations where no payment info is collected #}
                            {{ lang.checkout_no_payment_needed|raw }}
                        </li>
                    </ol>
			<div id="stink-free-guarantee"><span class="screen-reader-text">Stink Free Guarantee</span></div>
                </div><!-- .fc_inner -->
            </fieldset><!-- #fc_payment -->

                    <div id="fc_complete_order_button_container" class="fc_row fc_row_actions">
                        <a id="fc_complete_order_button" class="confirm_order_btn fc_button{{ submit_button_class }}" type="button" value="{{ submit_button_value }}" onclick="FC.checkout.validateAndSubmit()"><span class="screen-reader-text">{{ submit_button_value }}</span></a>
                        <div id="fc_complete_order_processing" style="display:none;"><strong class="fc_error"></strong> <br /><img src="//cdn.foxycart.com/static{{ base_directory }}/images/ajax-loader.gif?ver=1" alt="{{ lang.checkout_loading|raw }}" width="220" height="19" /></div>
                    </div><!-- #fc_complete_order_button_container -->

            <span class="fc_clear">&nbsp;</span>
        </div><!-- #fc_payment_container -->
    {% endblock checkout_payment %}



    </div><!-- #fc_data_entry_container -->



    {% else %} {# is_subscription_cancel #}



        {% block subscription_cancel %}
        <div id="fc_subscription_cancel_message">
            {{ lang.checkout_subscription_cancel_message|raw }}
        </div><!-- #fc_subscription_cancel_message -->

        <div id="fc_complete_order_button_container" class="fc_row fc_row_actions">
            <button id="fc_complete_order_button" class="fc_button{{ submit_button_class }}" type="button" value="{{ submit_button_value }}" onclick="FC.checkout.validateAndSubmit()">{{ submit_button_value }}</button>
            <div id="fc_complete_order_processing" style="display:none;"><strong class="fc_error"></strong> <br /><img src="//cdn.foxycart.com/static{{ base_directory }}/images/ajax-loader.gif?ver=1" alt="{{ lang.checkout_loading|raw }}" width="220" height="19" /></div>
        </div><!-- #fc_complete_order_button_container -->
        {% endblock subscription_cancel %}



    {% endif %}{# not is_subscription_cancel #}



</form>
<span class="fc_clear">&nbsp;</span>
</div><!-- #fc_checkout_container -->
<span class="fc_clear">&nbsp;</span>
<br/><br/><br/><br/><br/>


<!-- ###########################################################################
    END checkout
    ########################################################################### -->
{# END CHECKOUT TWIG TEMPLATE #}



{% endblock checkout %}

NavEE Select
============

ExpressionEngine fieldtype to select which NavEE navigation should be used for a specific channel entry.

## How it works
It's pretty simple, really. Just add NavEE Select as a fieldtype into any channel you where you want your users to have the ability to select the appropriate navigation for their page. When you create the fieldtype, you will be able to limit which navigations are available for that channel.

NavEE Select will output the nav_title for the navigation your user selected - which you can then pass into your NavEE template code in the usual manner.

## Usage

	{exp:navee:nav nav_title="{the_name_you_gave_this_field}"}

## Requires
* ExpressionEngine
* [NavEE Module](http://fromtheoutfit.com/navee)
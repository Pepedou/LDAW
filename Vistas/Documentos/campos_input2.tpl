

{* key always available as a property *}
{* {foreach $ids as $value}
  
<a href="#" onClick=actualiza({$value},"{$value@key}")>{$value@key}</a> <br>
{/foreach}*}

{foreach $ids as $value}

    <a target='_blank' href="{$value}">{$value@key}</a> <br>
{/foreach}




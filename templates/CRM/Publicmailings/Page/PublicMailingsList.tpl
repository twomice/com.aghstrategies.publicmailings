<ul class="mailings">
{foreach from=$mailings key=key item=value}
  <li><a href="{$foreach_url}?reset=1&id={$value.id}">{$value.subject}</a> - {$value.scheduled_date|crmDate}</li>
{/foreach}
</ul>
{include file="CRM/common/pager.tpl" location="bottom"}

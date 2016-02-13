<div class="form-group {if $messages && $messages->filter($name)}has-error{/if}">
	{if $title}<label>{$title|e}</label>{/if}

	{if $type == checkbox}
		<div class="checkbox">
			<label>
				<input type="checkbox" name="{$name|e}" value="{$value|default:"y"|e}"
					{if $userData[$name]}checked="checked"{/if}
					{if $disabled}disabled="disabled"{/if}> {$text|e}
			</label>
		</div>

	{elseif $type == textarea}
		<textarea class="form-control" placeholder="{$placeholder|e}" name="{$name|e}" {if $rows}rows="{$rows|e}"{/if}
				{if $disabled}disabled="disabled"{/if} {if $style}style="{$style}"{/if}>{$userData[$name]|e}</textarea>

	{elseif $type == "select"}
		<select class="form-control" name="{$name|e}" {if $disabled}disabled="disabled"{/if}>
			{if not $no_empty}<option value=""></option>{/if}
			{foreach $values as $k => $entry}
				{if $keys}
					{if is_array($entry)}
						<option value="{$entry[$keys[0]]|e}" {if $entry[$keys[0]] == $userData[$name]}selected="selected"{/if}>{$entry[$keys[1]]|e}</option>
					{else}
						<option value="{$entry->$keys[0]|e}" {if $entry->$keys[0] == $userData[$name]}selected="selected"{/if}>{$entry->$keys[1]|e}</option>
					{/if}
				{else}
					<option value="{$k|e}" {if $k == $userData[$name]}selected="selected"{/if}>{$entry|e}</option>
				{/if}
			{/foreach}
		</select>

	{elseif $type == file}
		{if $userData[$name]}<img src="{$userData[$name]}" />{/if}
		<input type="file" name="{$name|e}" />

	{elseif $type == person}
		<div class="form-group form-group-sm">
			<input type="hidden" name="{$name|e}" class="x-person-id" />
			{*<label>Пользователь</label>*}
			<input type="text" class="form-control x-search-person" placeholder="{$placeholder|e}" />
		</div>

	{else}
		<input class="form-control {$class}" type="{$input_type|default:"text"}" name="{$name|e}"
		   placeholder="{$placeholder|e}" value="{if $dateFormat}{$userData[$name]|date_format:$dateFormat|e}{else}{$userData[$name]|default:$default|e}{/if}"
			{if $readonly}readonly="readonly"{/if} {if $maxlength}maxlength="{$maxlength|e}"{/if} />
	{/if}

	{if $messages && $messages->filter($name)}
		{foreach $messages->filter($name) as $msg}
			<p class="help-block">{$msg|e}</p>
		{/foreach}
	{elseif $descr}
		<p class="help-block">{$descr|e}</p>
	{elseif $descr_html && is_array($descr_html)}
		{foreach $descr_html as $str}
			{if trim($str)}<p class="help-block">{$str}</p>{/if}
		{/foreach}
	{elseif $descr_html}
		<p class="help-block">{$descr_html}</p>
	{/if}
</div>

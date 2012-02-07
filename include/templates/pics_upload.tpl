<div class="box">
	<div class="upload">
		<input type="file" name="file" /> <input type="submit" name="upload" value="hochladen" class="btn" />
	</div>
	<div class="hl">
		Deine hochgeladenen Fotos:
	</div>
	{if $pics|@count < 1}noch nix hochgeladen{else}
	{foreach $pics as $pic}
	{if ($pic@iteration is div by 4) || ($pic@first)}
	<div class="row">
	{/if}
		<div class="pic">
			<div class="del"><a href="?action=del&amp;id={$pic.id}" onclick="return confirm('Foto wirklich löschen?');" title="Foto löschen">x</a></div>
			<img src="/gfx/cache/pics/medium/{$pic.pic}.jpg" alt="" />
		</div>
	{if ($pic@iteration is div by 3) || ($pic@last)}
	</div>
	{/if}
	{/foreach}
	{/if}
</div>
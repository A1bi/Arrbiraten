<div class="pics">
	<div class="hcen">
		<input type="file" name="file" /> <input type="submit" name="upload" value="hochladen" class="btn" />
	</div>
	<div class="hl">
		Deine hochgeladenen Fotos
	</div>
	{if $pics|@count < 1}noch nix hochgeladen{else}
	<div class="row">
	{foreach $pics as $pic}
		<div class="pic">
			<div class="del"><a href="?action=delPic&amp;id={$pic.id}{$add}" onclick="return confirm('Foto wirklich löschen?');" title="Foto löschen">x</a></div>
			<img src="/gfx/cache/pics/medium/{$pic.pic}.jpg" alt="" />
		</div>
	{if ($pic@iteration is div by 3)}
	</div>
	<div class="row">
	{/if}
	{/foreach}
	</div>
	{/if}
</div>
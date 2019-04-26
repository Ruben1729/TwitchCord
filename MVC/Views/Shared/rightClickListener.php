<?php
?>
<style>
	.container{
		background: #f6f6f6;
		font-size: 10px;
	}

	.context-menu{
		background: #f6f6f6;
		width: 200px;
		height: auto;
		box-shadow: 0 0 5px 0 black;
		position: absolute;
	}

	.context-menu ul{
		list-style: none;
		padding: 0px 0px 0px 0px;
	}

	.context-menu ul li{
		padding: 10px 5px 10px 5px;
		border-left: 4px solid transparent;
		cursor: pointer;
	}

	.context-menu ul li:hover{
		background: #eee;
		border-left: 4px solid #666;
	}
</style>
<div class="container">
	<div id="contextMenu" class="context-menu">
		<ul>
			<li>
				Set As Channel Picture
			</li>
			<li>
				Set As Profile Picture
			</li>
		</ul>
	</div>
</div>

<script>
	window.onclick = hideContextMenu;
	var contextMenu = document.getElementById('contextMenu');

	function showContextMenu(event){
		contextMenu.style.display = 'block';
		contextMenu.style.left = event.clientX + 'px';
		contextMenu.style.top = event.clientY + 'px';
		return false;
	}

	function hideContextMenu(event){
		if(event.target.tagName !== "IMG"){
			contextMenu.style.display = 'none';
		}
	}
</script>
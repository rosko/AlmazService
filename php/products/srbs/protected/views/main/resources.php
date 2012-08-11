<div id="page1_title"><!-- #page_inform-->
				
    <div id="page1_title_text"><p>Аудио, Видео ресусры</p></div>
			
	<div id="page1_title_img"></div>
			
</div><!-- #page_inform-->	

<div id="content2"><!-- #content-->	

	<div id="control_content">
				
		<div id="banner_links_1">
						
			<h2>Текущий фильтр</h2>
							
				<ul>
							
					<li><img class="links" src="../img/banner1_links.gif" alt="marker"><a href='/'>Аудио</a><img class="line" src="../img/line.gif" alt="line"></li>
																	   
					<li><img class="links" src="../img/banner1_links.gif" alt="marker"><a href='/'>Спикер: Скопич</a><img class="line" src="../img/line.gif" alt="line"></li>
								
					<li><img class="links" src="../img/banner1_links.gif" alt="marker"><a href='/'>Серия проповедей: ...</a><img class="line" src="../img/line.gif" alt="line"></li>
							
					<li><img class="links" src="../img/banner1_links.gif" alt="marker"><a href='/'>Место из Библии</a><img class="line" src="../img/line.gif" alt="line"></li>
						
					<li><img class="links" src="../img/banner1_links.gif" alt="marker"><a href='/'>Дата</a><img class="line" src="../img/line.gif" alt="line"></li>
								
				</ul>
												
		    <h2>Фильтры</h2>
											
				<ul>
														
					<li><img class="links" src="../img/banner_links.gif" alt="marker"><a href='/'>Аудио</a><img class="line" src="../img/line.gif" alt="line"></li>

					<li><img class="links" src="../img/banner_links.gif" alt="marker"><a href='/'>Видео</a><img class="line" src="../img/line.gif" alt="line"></li>

					<li><img class="links" src="../img/banner_links.gif" alt="marker"><a href='/'>Конспекты</a><img class="line" src="../img/line.gif" alt="line"></li>

					<li><img class="links" src="../img/banner_links.gif" alt="marker"><a href='/'>Место писания из Библии</a><img class="line" src="../img/line.gif" alt="line"></li>						
															
					<li><img class="links" src="../img/banner_links.gif" alt="marker"><a href='/'>Дата</a><img class="line" src="../img/line.gif" alt="line"></li>						

					<li><img class="links" src="../img/empty_links.gif" alt="marker"><a href='/'></a><img class="line" src="../img/line.gif" alt="line"></li>						

    				<li><img class="links" src="../img/empty_links.gif" alt="marker"><a href='/'></a><img class="line" src="../img/line.gif" alt="line"></li>						
												
					<li><img class="links" src="../img/empty_links.gif" alt="marker"><a href='/'></a><img class="line" src="../img/line.gif" alt="line"></li>						
											
					<li><img class="links" src="../img/empty_links.gif" alt="marker"><a href='/'></a><img class="line" src="../img/line.gif" alt="line"></li>						

					<li><img class="links" src="../img/empty_links.gif" alt="marker"><a href='/'></a><img class="line" src="../img/line.gif" alt="line"></li>						
					
    				<li><img class="links" src="../img/empty_links.gif" alt="marker"><a href='/'></a><img class="line" src="../img/line.gif" alt="line"></li>						
					
					<li><img class="links" src="../img/empty_links.gif" alt="marker"><a href='/'></a><img class="line" src="../img/line.gif" alt="line"></li>						
							
					<li><img class="links" src="../img/empty_links.gif" alt="marker"><a href='/'></a><img class="line" src="../img/line.gif" alt="line"></li>						
				</ul>			
																			   
		</div>

	</div>
	
    	<div id="output_request"><!-- #output_request-->

            <?php 
            $this->widget('resourceitem', array(
                'itemView' => 'resourceitemview',
                'dataProvider'=>new CArrayDataProvider($data)
            ));
            ?>

    	</div><!-- #output_request-->
						
</div><!-- #content-->
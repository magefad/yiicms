/* Galleria Folio Theme 2012-04-04 | http://galleria.io/license/ | (c) Aino */
(function ($) {
	Galleria.addTheme({
		name: "folio",
		author: "Galleria",
		css: "galleria.folio.css",
		defaults: {
			transition: "pulse",
			thumbCrop: "width",
			imageCrop: false,
			carousel: false,
			show: false,
			easing: "galleriaOut",
			fullscreenDoubleTap: false,
			trueFullscreen: false,
			_webkitCursor: false,
			_animate: true
		},
		init: function (options)
		{
			Galleria.requires(1.27, "This version of Folio theme requires Galleria version 1.2.7 or later");
			this.addElement("preloader", "loaded", "close").append({
				container:"preloader",
				preloader:"loaded",
				stage:"close"
			});

			var theme, stage, thumbnails, images, info, loader, target, imgNumber, targetWidth, posLeft, indexImage, historyHash, fullScreen, setInfoCss, arrayMin, arrayMax, generateThumbnails;
				theme = this;
				stage = this.$("stage");
				thumbnails = this.$("thumbnails");
				images = this.$("images");
				info = this.$("info");
				loader = this.$("loader");
				target = this.$("target");
				imgNumber = 0;
				targetWidth = target.width();
				posLeft = 0;
				indexImage = options.show;
				historyHash = window.location.hash.substr(2);
				fullScreen = false;

			/**
			 * Set info block for image
			 * @param width
			 */
			setInfoCss = function (width)
			{
				theme.$("info").css({
					left        :Math.max(20, $(window).width() / 2 - width / 2 + 10),
					marginBottom:theme.getData().video ? 40 : 0
				});
			};
			arrayMin = function (array)
			{
				return Math.min.apply(window, array);
			};
			arrayMax = function (array)
			{
				return Math.max.apply(window, array);
			};
			/**
			 * All thumbnails div element
			 * @param thumbnails
			 * @param properties
			 */
			generateThumbnails = function (thumbnails, properties)
			{
				properties = $.extend({
					speed   :400,
					width   :190,
					onbrick :function (){},
					onheight:function (){},
					delay   :0,
					debug   :false
				},properties);
				thumbnails = $(thumbnails);

				var thumbElem = thumbnails.children(),
					thumbnailsWidth = thumbnails.width(),
					rows = Math.floor(thumbnailsWidth / properties.width),
					colsHeights = [],
					h, i, j, maxHeight, l = {
						"float" :"none",
						position:"absolute",
						display :$.browser.safari ? "inline-block" : "block"
					};

				if ( thumbnails.data("colCount") === rows )
					return;

				thumbnails.data("colCount", rows);
				if ( !thumbElem.length )
					return;

				for ( h = 0; h < rows; h++ )
					colsHeights[h] = 0;

				thumbnails.css("position", "relative");
				thumbElem.css(l).each(function(imageNumber, elem)
				{
					elem = $(elem);
					for ( h = rows - 1; h > -1; h-- )
						colsHeights[h] === arrayMin(colsHeights) && (i = h);
					j = {
						top : colsHeights[i],
						left: properties.width * i
					};

					if ( typeof j.top != "number" || typeof j.left != "number" )
						return;

					if ( properties.speed )
					{
						window.setTimeout(function(elem, property, position)
						{
							return function(d)
							{
								Galleria.utils.animate(elem, position, {
									easing  : "galleriaOut",
									duration: property.speed,
									complete: property.onbrick
								});
							}
						}(elem, properties, j), imageNumber * properties.delay);
					}
					else
					{
						(elem.css(j), properties.onbrick.call(elem));
					}
					elem.data("height") || elem.data("height", elem.outerHeight(true));
					colsHeights[i] += elem.data("height");
				});

				//get height (max) in cols
				maxHeight = arrayMax(colsHeights);
				if ( maxHeight < 0 )
					return;
				if ( typeof maxHeight != "number" )
					return;

				if ( properties.speed )
				{
					thumbnails.animate({
						height:arrayMax(colsHeights)
					},properties.speed, properties.onheight);
				}
				else
				{
					(thumbnails.height(arrayMax(colsHeights)), properties.onheight.call(thumbnails));
				}
			};

			Galleria.OPERA && this.$("stage").css("display", "none");
			this.bind("fullscreen_enter", function(e)
			{
				images.css("visibility", "hidden");
				stage.show();
				this.$("container").css("height", "100%");
				fullScreen = true;
			}),
			this.bind("fullscreen_exit", function(e)
			{
				this.getData().iframe && ($(this._controls.getActive().container).find("iframe").remove(), this.$("container").removeClass("iframe"));
				stage.hide();
				thumbnails.show();
				info.hide();
				fullScreen = false;
			}),
			this.bind("loadstart", function (e)
			{
				Galleria.TOUCH && this.$("image-nav").toggle(!!e.galleriaData.iframe);
			}),
			this.bind("thumbnail", function (e)
			{
				this.addElement("plus");
				Galleria.History && e.index === parseInt(historyHash, 10) && this.enterFullscreen(function ()
				{
					this.show(historyHash);
				});

				var thumbImg = e.thumbTarget,
					thumbInfo = this.$("plus").css({display: "block"}).insertAfter(thumbImg);

				//@todo check var impl, and var name
				var thumbElem = $(thumbImg).parent().data("index", e.index);

				options.showInfo && this.hasInfo(e.index) && thumbInfo.append("<span>" + this.getData(e.index).title + "</span>");
				posLeft = posLeft || $(thumbImg).parent().outerWidth(true);
				$(thumbImg).css("opacity", 0);
				thumbElem.unbind(options.thumbEventType);
				Galleria.IE ? thumbInfo.hide() : thumbInfo.css("opacity", 0);

				if ( Galleria.TOUCH )
				{
					thumbElem.bind("touchstart",function ()
					{
						thumbInfo.css("opacity", 1)
					}).bind("touchend", function ()
					{
						thumbInfo.hide()
					});
				}
				else
				{
					thumbElem.hover(function()
					{
						Galleria.IE ? thumbInfo.show() : thumbInfo.stop().css("opacity", 1);
					},
					function()
					{
						Galleria.IE ? thumbInfo.hide() : thumbInfo.stop().animate({opacity: 0}, 300);
					}),
					imgNumber++,
					this.$("loaded").css("width", imgNumber / this.getDataLength() * 100 + "%");

					imgNumber === this.getDataLength() && (this.$("preloader").fadeOut(100), generateThumbnails(thumbnails,
					{
						width   : posLeft,
						speed   : options._animate ? 400 : 0,
						onbrick : function()
						{
							var thumbElem = this,
								thumbImg = $(thumbElem).find("img");

							window.setTimeout(function(thumbImg)
							{
								return function()
								{
									Galleria.utils.animate(thumbImg, {opacity: 1}, {duration: options.transition_speed});
									thumbImg.parent().bind(Galleria.TOUCH ? "mouseup" : "click", function()
									{
										thumbnails.hide();
										info.hide();
										var thumbOpened = $(this);
										theme.enterFullscreen(function()
										{
											theme.show(thumbOpened.data("index"));
											thumbOpened.data("index") === indexImage && (images.css("visibility", "visible"), info.toggle(theme.hasInfo()));
										});
									})
								}
							}(thumbImg), options._animate ? thumbImg.parent().data("index") * 100 : 0)
						},
						onheight: function()
						{
							target.height(thumbnails.height());
						}
					}));
				}
			});
			this.bind("loadstart", function(e)
			{
				e.cached || loader.show();
			});
			this.bind("loadfinish", function(e)
			{
				info.hide();
				indexImage = this.getIndex();
				images.css("visibility", "visible");
				loader.hide();
				this.hasInfo() && options.showInfo && fullScreen && info.fadeIn(options.transition ? options.transitionSpeed : 0);
				setInfoCss($(e.imageTarget).width());
			});
			!Galleria.TOUCH && !options._webkitCursor && (this.addIdleState(this.get("image-nav-left"), {
				left: -100
			}),
				this.addIdleState(this.get("image-nav-right"), {
					right: -100
				}),
				this.addIdleState(this.get("info"), {
					opacity: 0
				}));

			this.$("container").css({
				width : options.width,
				height: "auto"
			});

			options._webkitCursor && Galleria.WEBKIT && !Galleria.TOUCH && this.$("image-nav-right,image-nav-left").addClass("cur");
			Galleria.TOUCH && this.setOptions({
				transition       : "fadeslide",
				initialTransition: false
			});
			this.$("close").click(function ()
			{
				theme.exitFullscreen();
			});
			$(window).resize(function()
			{
				if ( fullScreen )
				{
					theme.getActiveImage() && setInfoCss(theme.getActiveImage().width);
					return;
				}
				var width = target.width();
				width !== targetWidth && (targetWidth = width, generateThumbnails(thumbnails, {
					width   : posLeft,
					delay   : 50,
					debug   : true,
					onheight: function()
					{
						target.height(thumbnails.height());
					}
				}));
			});
		}
	})
})(jQuery);
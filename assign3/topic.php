<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8" />
		<meta name="description" content="APNG topic" />
		<meta name="keywords" content="APNG, animated portable network graphics, topic" />
		<meta name="author" content="Ravish" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0" />
		<title>APNG topic</title>
		<link href="styles/style.css" rel="stylesheet" />
		<link href="https://fonts.googleapis.com/css?family=Google+Sans" rel="stylesheet" />
		<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet" />
	</head>

	<body>
		<input type="checkbox" id="toggleMode" />
		<?php
            include("header.inc");
        ?>
		<main id="parallax-container">
			<section class="parallax parallax-bg">
				<h1>Animated Portable Network Graphics (APNG)</h1>
				<h2>What Is It?</h2>
			</section>
			<section class="no-parallax">
				<h3>Familiar, but not quite?</h3>
				<p>
					It extends the popular Portable Network Graphics (PNG) file format specification to allow
					images to be animated similarly to animated GIF files with additional features. The first
					frame of an APNG file is stored as a normal PNG. Since it is an extension of PNG, most
					standard decoders will be able to display the file without additional work.
				</p>
				<dl>
					<dt>Basically, it is:</dt>
					<dd>A PNG file</dd>
					<dd>With additional chunks of data</dd>
					<dd>Allows for animations</dd>
				</dl>
			</section>
			<section class="parallax parallax-bg">
				<h2>Why Does It Exist?</h2>
			</section>
			<section class="no-parallax">
				<h3>History</h3>
				<p>
					It was first developed by Mozilla Corporation in 2004 to store animations needed in UIs
					(e.g. loading throbbers) to replace MNG animations which were deprecated the year before.
					MNGs had less functionality than APNGs with a much larger file size due to their decoder,
					the thing that will read the read and extract headers from the sequence of bytes.
				</p>
				<h3>Why isn't it more mainstream?</h3>
				<p>
					APNG had a lukewarm reception on release as maintainers on the PNG format debated that
					their format was strictly a single-image format and it was seen as such in the wider
					community. The rationale was that applications do not need and will not support multiple
					images per file due to having separate file formats for animations because a single image
					and a sequence of images are fundamentally used differently.
				</p>
				<p>
					The only way for a software to correctly distinguish between PNG and APNG is by reading
					the ancillary chunks which aren't required to use PNGs, so if a software didn't know about
					APNGs, the first frame would show up as a typical PNG.
				</p>
				<p>
					So with the maintainers of the file format against the idea of this implementation and the
					data of the animation hidden inside ancillary chunks that decoders used in applications
					could skip, APNG never grew in popularity.
				</p>
				<aside>
					<p id="scribble">
						Fun fact: APNG almost had a half-sibling called MNG (Mozilla Network Graphic), but it
						was abandoned as nobody bothered to support it.
						<br />
						<em> *Not to be confused with Multiple-image Network Graphics (MNG)! </em>
					</p>
					<img src="images/bouncy.png" alt="HTML Tutorial" id="aside-img" />
				</aside>
			</section>

			<section class="parallax parallax-bg">
				<h2>Web Browser Support</h2>
			</section>
			<section class="no-parallax">
				<h3>Support for APNG on currently active browsers</h3>
				<p>
					When an application does not have APNG support, it is treated as a PNG and only the first
					frame is displayed.
				</p>
				<table>
					<tr class="align-center">
						<th>Browsers</th>
						<th>Versions</th>
					</tr>
					<tr>
						<td>Google Chrome</td>
						<td class="align-right">96-102</td>
					</tr>
					<tr>
						<td>Firefox</td>
						<td class="align-right">96-100</td>
					</tr>
					<tr>
						<td>Microsoft Edge</td>
						<td class="align-right">97-99</td>
					</tr>
					<tr>
						<td>Safari</td>
						<td class="align-right">14.1-15.4</td>
					</tr>
					<tr>
						<td>Opera</td>
						<td class="align-right">11</td>
					</tr>
					<tr>
						<td>Safari on IOS</td>
						<td class="align-right">12.5-15.4</td>
					</tr>
					<tr>
						<td>Chrome for android</td>
						<td class="align-right">99</td>
					</tr>
					<tr>
						<td>Samsung internet</td>
						<td class="align-right">16</td>
					</tr>
					<tr>
						<td>Internet Explorer</td>
						<td class="align-right">not supported</td>
					</tr>
				</table>
			</section>
			<section class="parallax parallax-bg">
				<h2>How Does It Work?</h2>
			</section>
			<section class="no-parallax">
				<h3>File Structure</h3>
				<p>
					Since the APNG is an extension on the PNG file format, the base structure of the
					file/datastream is the same.
				</p>
				<figure>
					<img src="images/lattice_diagram.png" alt="lattice diagram" />
					<figcaption>
						The above image shows the file structure of a PNG file without a PLTE chunk.
					</figcaption>
				</figure>
			</section>
			<section class="parallax parallax-bg">
				<h2>Critical Chunks</h2>
			</section>
			<section class="no-parallax">
				<p>
					Critical Chunks are parts of data that must be present in the datastream for a successful
					decode of a PNG/APNG image and they must appear in this order:
				</p>
				<ol>
					<li>1 PNG Signature</li>
					<li>1 IHDR chunk</li>
					<li>1+IDAT chunks</li>
					<li>1 IEND chunk</li>
				</ol>
				<p>
					A Palette (PLTE) chunk can also be added after the IHDR as a critical chunk but is
					optional depending on the colour type you choose.
				</p>
				<p>A PLTE chunk must exist if you use colour type:</p>
				<ul>
					<li>3 (indexed-colour/Palette-Based)</li>
				</ul>
				<p><b>Can appear</b> in:</p>
				<ul>
					<li>2 (Truecolor/RGB) and 6 (Truecolor/RGB with Alpha)</li>
				</ul>
				<p>And <b>must not</b> be in the datastream if you use:</p>
				<ul>
					<li>0 (Grayscale) and 4 (Grayscale with Alpha channel)</li>
				</ul>

				<h3>PNG Signature</h3>
				<p>
					All APNGs start with a PNG signature header that communicates that the subsequent data
					will be a PNG starting with an IHDR chunk and ending in an IEND chunk
				</p>

				<h3>IHDR - Image Header</h3>
				<p>
					This chunk must appear first after the PNG signature and contains information on the
					PNG's:
				</p>
				<ul>
					<li>Width</li>
					<li>Height</li>
					<li>Bit Depth</li>
					<li>Colour Type</li>
					<li>Compression Method</li>
					<li>Filter Method</li>
					<li>Interface Method</li>
				</ul>

				<h3>IDAT - Image Data</h3>
				<p>
					This chunk contains the actual image data so this is where you would store multiple frames
					of your animation and they must appear consecutively. They do not have a fixed size and
					boundaries have no semantic significance as all of them are concatenated together in the
					compressed datastream.
				</p>
				<p>The first IDAT chunk is the default image shown if the decoder encounters an error.</p>
				<h3>IEND Image trailer</h3>
				<p>
					Must appear last and it marks the end of the PNG/APNG datastream. Its data field is also
					empty.
				</p>
			</section>

			<section class="parallax parallax-bg">
				<h2>Ancillary Chunks</h2>
			</section>
			<section class="no-parallax">
				<p>
					These chunks are not necessary if you want to successfully decode a PNG/APNG file. The
					APNG specifications add three new ancillary chunks.
				</p>
				<ul>
					<li>acTL: The Animation Control Chunk</li>
					<li>fcTL: The Frame Control Chunk</li>
					<li>fdAT: The Frame Data Chunk</li>
				</ul>
				<figure>
					<img src="images/APNG_chunks.png" alt="Diagram illustrating a possible way to assemble an animated PNG from three individual PNG files"/>
					<figcaption> Diagram illustrating a possible way to assemble an animated PNG from three individual PNG files</figcaption>
				</figure>
				<h3>Animation control chunk (acTL)</h3>
				<p>
					This appears before the IDAT chunks and communicates to the decoder the file is an APNG
					along with the number of frames and the number of times to loop the animation. The number
					of frames must equal the number of fcTL chunks or an error is thrown.
				</p>
				<h3>Frame control chunk (fcTL)</h3>
				<p>
					Exactly one these chunks must appear before the first IDAT or fdAT chunk of the frame it
					applies its content to.
				</p>
				<p>The information that fcTL chunk holds for the upcoming frame is:</p>
				<ul>
					<li>Sequence number of the animation chunk.</li>
					<li>Width and height of the following frame.</li>
					<li>X and Y position at which to render the following frame.</li>
					<li>
						A frame delay fraction numerator/denominator that will decide the time to display the
						current frame.
						<ul>
							<li>
								If the numerator is 0 then the decoder will render the frame as quickly as
								possible, though programs will set a more reasonable lower bound.
							</li>
						</ul>
					</li>
					<li>How the next frame should be disposed of before rendering the subsequent frame.</li>
					<li>
						Whether the frame is to be alpha blended into the previous frame or completely replace
						it
					</li>
				</ul>
				<figure>
					<img src="images/alpha_channel.png" alt="Using the Alpha Channel" />
					<figcaption>
						How translucency can be applied to an object using the alpha channel.
					</figcaption>
				</figure>
				<h3>Frame data chunk (fDat)</h3>
				<p>
					fdAT chunks have the same function and similar structure as an IDAT chunk. The only
					difference is that fdDAT chunks have an additional 4 bytes at the start that indicates the
					sequence number again.
				</p>
				<h3>Chunk Sequence Numbers</h3>
				<p>
					A 4 byte sequence number appears in both the fcTl and fdAT chunks and these are used to
					detect or fix the sequence of the frames. The first chunk must contain sequence number 0
					and the remaining sequences must be in order, without gaps or duplicates.
				</p>
			</section>

			<section class="parallax parallax-bg">
				<h2>Invalid APNG Handling</h2>
			</section>

			<section class="no-parallax">
				<h3>What does a broken APNG look like?</h3>
				<p>
					As frames can be displayed before the entire image has been read, errors may not be
					detected until partway through the animation. In this case, decoders will drop all
					subsequent frames and revert to the default image, but depending on the error in the
					datastream, the default image may not be shown, the image won't load and it could crash
					your software.
				</p>
				<figure>
					<img src="images/incorrect_chunks.png" alt="incorrect chunks" />
					<figcaption>How incorrect APNG chunks are handled in the browser (green = successful)</figcaption>
				</figure>
				<p>A green rectangle indicates the APNG has loaded correctly</p>
			</section>

			<section class="parallax parallax-bg">
				<h2>Competitors</h2>
			</section>

			<section class="no-parallax">
				<h3>GIF</h3>
				<figure>
					<img src="images/gif-apng-1.gif" alt="gif vs apng chicken" />
					<figcaption>Gif vs APNG</figcaption>
				</figure>
				<p>
					APNG's most popular competitor is GIF that was initially released back in 1987 and was not
					designed as an animation medium but could store multiple images in one file. GIF also does
					not specify repeating animations but most modern browsers automatically loop them using
					Application Block (NAB).
				</p>
				<p>
					It grew in popularity due to it using LZW data compression that was superior compared to
					its rivals on release. It allowed large images to be downloaded reasonably quickly despite
					slow connections and with GIFs supporting interlacing, allowed the user to somewhat
					recognise the partially downloaded image and cancel the download if it didn’t meet
					expectations.
				</p>
				<p>
					It is now widely used for small animations and low-resolution video clips as reactions in
					online messaging to convey emotions and feelings instead of words.
				</p>
				<h3>WebP</h3>
				<p>
					Relatively new to the scene being released in 2010 by Google that provides superior
					lossless and lossy compression intended as a replacement for both the PNG and GIF file
					formats. It got its animation features a year after the initial release and is very widely
					supported by modern browsers.
				</p>
				<figure>
					<img src="images/webp.png" alt="support for webp file format" />
					<figcaption>Web Browser support for WebP file formats</figcaption>
				</figure>
				<h3>Other animation formats</h3>
				<p>
					Videos now can replace APNGs and GIFs in the way they are used on the web. The rapid
					adoption of HTML5 video and Flash plugin being phased out allowed web pages to natively
					support video embeds and the ability to loop them using JavaScript which gave them the
					same appearance as an APNG/GIF with size and speed advantages of compressed video.
				</p>
				<p>
					Some sites will now automatically convert GIF files uploaded to its site to GIFV or MPEG-4
					videos to conserve disk space for the same image quality. WebM is another file format that
					can be embedded into HTML5 video rising in popularity too due to its speed and quality on
					the web.
				</p>
			</section>

			<section class="parallax parallax-bg">
				<h2>APNG Competitors</h2>
			</section>

			<section class="no-parallax">
				<h3>File Size</h3>
				<p>
					APNG uses a superior compression algorithm compared to GIF's LZW compression that will
					result in smaller file sizes. It can predict the colour of a chunk of pixels based on the
					surrounding pixels that reduces the amount of information stored in a file. This will
					result in around a ≈17% reduction in file size for the same image. WebP and APNG will
					result in similar file sizes when using the highest compression but an APNG will generally
					load faster on a web page, though depending on the compression, a WebP can have up to a
					26% smaller file size over a best scenario PNG.
				</p>
				<div class="overflowTable">
					<table>
						<tr class="align-center">
							<th>File dimension</th>
							<th>GIF</th>
							<th>Webp</th>
							<th>APNG</th>
							<th>GIF vs APNG</th>
							<th>WebP vs APNG</th>
						</tr>
						<tr>
							<td>800x450</td>
							<td class="align-right">37.9MB</td>
							<td class="align-right">30.82MB</td>
							<td class="align-right">31.22MB</td>
							<td class="align-right">-17.63%</td>
							<td class="align-right">1.30%</td>
						</tr>
						<tr>
							<td>300x169</td>
							<td class="align-right">4.93MB</td>
							<td class="align-right">4.16MB</td>
							<td class="align-right">3.97MB</td>
							<td class="align-right">-19.47%</td>
							<td class="align-right">-4.57%</td>
						</tr>
						<tr>
							<td></td>
							<td></td>
							<td></td>
							<td><span class = "bold">Average</span></td>
							<td class="align-right">-17.35%</td>
							<td class="align-right">0.03%</td>
						</tr>
					</table>
				</div>
				<p>
					If you compare these multi-image file formats to MP4 and WebM for an animation, the
					benefits of using other animation formats is apparent.
				</p>
				<table>
					<tr class="align-center">
						<th>File Type</th>
						<th>Size</th>
						<th>Size vs APNG</th>
					</tr>
					<tr>
						<td>Unoptimized Gif</td>
						<td class="align-right">37.9MB</td>
						<td class="align-right">22.77%</td>
					</tr>
					<tr>
						<td>Default Webp</td>
						<td class="align-right">30.8MB</td>
						<td class="align-right">-0.16%</td>
					</tr>
					<tr>
						<td>APNG Zopfli 100 Iterations</td>
						<td class="align-right">30.9MB</td>
						<td class="align-right">0.00%</td>
					</tr>
					<tr>
						<td>Trimmed MP4</td>
						<td class="align-right">0.5MB</td>
						<td class="align-right">-98.52%</td>
					</tr>
					<tr>
						<td>WebM</td>
						<td class="align-right">0.2MB</td>
						<td class="align-right">-99.41%</td>
					</tr>
				</table>
				<h3>Colours</h3>
				<p>
					APNGs and WebP also support 24-bit colour (truecolor) which allows for millions of colours
					to be used in the one file compared to the mere 256 colours normally used in GIFs. It is
					possible to make GIFs in truecolor by splitting up an image into sections that don't have
					more than 256 different colours each, then displaying all the sections together in a tile.
					This will result in a very large file and not all GIF rendering programs can handle these
					tiled files correctly.
				</p>
				<figure>
					<img src="images/gif-many-colours-looped.gif" alt="A static GIF with more than 256 colours, combining many frames" />
					<figcaption>A static GIF with more than 256 colours, combining many frames</figcaption>
				</figure>
				<figure>
					<img src="images/colours.png" alt="colours of an APNG file" />
					<figcaption>Colours of an APNG file</figcaption>
				</figure>
				<h3>Support and Popularity</h3>
				<p>
					Despite its shortcomings of huge file sizes, limited colour, and slow encoding, GIFs
					remain the most widely supported and popular animation file format on the internet. A
					report on w3tech shows it has fallen in popularity recently compared to other file formats
					that have improved functionality and features than the GIF.
				</p>
				<p>
					WebP is increasing in popularity as a file format for the web that supports similar
					features as a PNG. An advantage they have is by default is a smaller file size which can
					increase the gap to up to a 26%.
				</p>
				<figure>
					<img src="images/trends.png" alt="Historical trends in the usage statistics of image file formats for websites, March 2022" />
					<figcaption>Historical trends in the usage statistics of image file formats for websites, March 2022</figcaption>
				</figure>
				<p>
					While PNG remains one of the most used file formats on the web, the adoption for APNG is
					still very narrow. The most visited websites support the APNG file format but beyond that,
					there aren't many websites that will read the ancillary chunks for APNG to display an
					animation.
				</p>
				<figure>
					<img src="images/statistics.png" alt="WebP vs. APNG usage statistics, March 2022 (w3techs.com)"/>
					<figcaption>WebP vs. APNG usage statistics, March 2022 (w3techs.com)</figcaption>
				</figure>
			</section>

			<section class="parallax parallax-bg">
				<h2>What Should You Use?</h2>
			</section>

			<section class="no-parallax">
				<h3>The verdict?</h3>
				<p>
					In the modern web, you really shouldn't be using GIFs anymore due to its huge file size
					and subpar visual quality and colour choice compared to existing alternatives. Hopefully
					it will be time to let the format rest after 34 years but it will have a rare appearance
					due to its portability and support on a wide range of sites but it's the last resort.
				</p>
				<p>
					If you're looking for the best quality, lots of features, and all the colours you can see,
					APNG is a good choice. APNGs greatest boon is that their parent format (PNG) is the most
					popular way to display images on the web, but that is also its greatest hurdle to gaining
					popularity. The confusion between the two has been enough to limit its support on a wide
					range of websites and programs to less than 1% of websites.
				</p>
				<figure>
					<img src="images/usage.png" alt="Percentages of websites using various image file formats"/>
					<figcaption>Percentages of websites using various image file formats</figcaption>
				</figure>
				<p>
					WebP seems like it has the best of both GIFs and APNG with solid quality and support on a
					larger variety of websites on top of having the smallest file size of the three. It will
					be harder to run into issues of having a slow loading animation from a large file size
					(we've all closed a gif if it doesn't load in 3 seconds) or having subsequent frames not
					playing at all when ancillary chunks are read in APNGs.
				</p>
				<p>
					If you were really looking for something to display an animation on your website, it's a
					no brainer to just embed an HTML5 video and do an extra step to loop the video in
					JavaScript. This is the method that will save you the most storage space and have the best
					quality for your animation. There also exists a plethora of websites and software that
					will help convert between the file types if needed when one of them isn't supported on the
					site you want to display them on.
				</p>
			</section>

			<section class="parallax parallax-bg">
				<h2>Summary</h2>
			</section>

			<section class="no-parallax">
				<h3>Wrapping things up</h3>
				<p>
					APNG came at a time when there were very limited alternatives and provided superior
					quality and size to its competitors. It was well received by few boasting how much better
					than GIF it was and pushed as a way to speed up a website. Sadly it failed gaining
					popularity due to differing visions by the maintainers where some wanted its
					implementation, and others pushed against it to be included in the PNG specification.
				</p>
				<p>
					An APNG just adds 3 chunks on top of the PNG file structure which when missing/skipped
					during decode, will display a static PNG image most of the time which will occur
					frequently due to its narrow support.
				</p>
				<p>
					In the modern day internet, the APNG is supported on the most visited sites but will still
					display a static image on the large majority of sites. Newer alternatives such as WebP and
					HTML5 video support provide better file size and similar quality that are replacing GIFs
					which was the goal of the APNG.
				</p>
			</section>

			<section class="parallax parallax-bg">
				<h2>References</h2>
			</section>

			<section class="no-parallax">
				<h3>Reference List</h3>
				<p class="citation">
					<span class="italic">APNG.</span>(2022, March 24). Wikipedia.<br/>
					<span class="indent"></span><a href="https://en.wikipedia.org/wiki/APNG" target="_blank" rel="noreferrer noopener">https://en.wikipedia.org/<wbr>wiki/APNG</a>
				</p>
				<p class="citation">
					<span class="italic">APNG fun fact.</span>(2019, December 18). Twitter.<br/>
					<span class="indent"></span><a href="https://twitter.com/foone/status/1206959487434670081?lang=bg" target="_blank" rel="noreferrer noopener">https://twitter.com/foone/status/<wbr>1206959487434670081?lang=bg</a>
				</p>
				<p class="citation">
					<span class="italic"> Mathilde E</span>(2020).Understanding and decoding PNGs.<br/>
					<span class="indent"></span><a href="https://medium.com/achiev/understanding-and-decoding-png-format-example-in-ts-b31fdde1151b#3324" target="_blank" rel="noreferrer noopener">https://medium.com/achiev/<wbr>understanding-and-decoding-png-format-example-in-ts-b31fdde1151b#3324</a>
				</p>
				<p class="citation">
					<span class="italic">Which browser supports APNG?</span><br/>
					<span class="indent"></span><a href="https://caniuse.com/apng" target="_blank" rel="noreferrer noopener">https://caniuse.com/apng</a>
				</p>
				<p class="citation">
					<span class="italic">PNG (Portable Network Graphics)</span>.Specification Version 1.2.(1999).<br/>
					<span class="indent"></span><a href="https://pmt.sourceforge.io/specs/png-1.2-pdg.html" target="_blank" rel="noreferrer noopener">https://pmt.sourceforge.io/specs/<wbr>png-1.2-pdg.html</a>
				</p>
				<p class="citation">
					<span class="italic">Portable Network Graphics (PNG) Specification</span>(Second Edition), W3C.(2003).<br/>
					<span class="indent"></span><a href="https://www.w3.org/TR/PNG/" target="_blank" rel="noreferrer noopener">https://www.w3.org/TR/PNG/</a>
				</p>
				<p class="citation">
					<span class="italic">PNG Specification: Rationale</span>.libpng.<br/>
					<span class="indent"></span><a href="http://www.libpng.org/pub/png/spec/1.1/PNG-Rationale.html#R.Why-not-these-features" target="_blank" rel="noreferrer noopener">http://www.libpng.org/pub/png/spec/1.1/<wbr>PNG-Rationale.html#R.Why-not-these-features</a>
				</p>
				<p class="citation">
					<span class="italic">APNG Specification</span>.MozillaWiki.<br/>
					<span class="indent"></span><a href="https://wiki.mozilla.org/APNG_Specification" target="_blank" rel="noreferrer noopener">https://wiki.mozilla.org/<wbr>APNG_Specification</a>
				</p>
				<p class="citation">
					<span class="italic">Definition of alpha blending</span>.PCMag.<br/>
					<span class="indent"></span><a href="https://www.pcmag.com/encyclopedia/term/alpha-blending" target="_blank" rel="noreferrer noopener">https://www.pcmag.com/encyclopedia/<wbr>term/alpha-blending</a>
				</p>
				<p class="citation">
					<span class="italic">APNG tests</span><br/>
					<span class="indent"></span><a href="https://philip.html5.org/tests/apng/tests.html" target="_blank" rel="noreferrer noopener">https://philip.html5.org/<wbr>tests/apng/tests.html</a>
				</p>
				<p class="citation">
					<span class="italic">GIFs Wikipedia</span><br/>
					<span class="indent"></span><a href="https://en.wikipedia.org/wiki/GIF" target="_blank" rel="noreferrer noopener">https://en.wikipedia.org/wiki/GIF</a>
				</p>
				<p class="citation">
					<span class="italic">>Which browser supports WebP?</span><br/>
					<span class="indent"></span><a href="https://caniuse.com/webp" target="_blank" rel="noreferrer noopener">https://caniuse.com/webp</a>
				</p>
				<p class="citation">
					<span class="italic">Introducing GIFV.</span>(2014).Imgur.<br/>
					<span class="indent"></span><a href="https://blog.imgur.com/2014/10/09/introducing-gifv/" target="_blank" rel="noreferrer noopener">https://blog.imgur.com/2014/10/09/introducing-gifv/</a>
				</p>
				<p class="citation">
					<span class="italic">An image format for the Web.</span>(2022).Google.<br/>
					<span class="indent"></span><a href="https://developers.google.com/speed/webp/" target="_blank" rel="noreferrer noopener">https://developers.google.com/speed/webp/</a>
				</p>
				<p class="citation">
					<span class="italic">PNG Image Types.</span>libpng.<br/>
					<span class="indent"></span><a href="http://www.libpng.org/pub/png/book/chapter08.html#png.ch08.div.5" target="_blank" rel="noreferrer noopener">http://www.libpng.org/pub/png/book/<wbr>chapter08.html#png.ch08.div.5</a>
				</p>
				<p class="citation">
					<span class="italic">Cory Dowdy.</span>(2017).Animated PNG VS. Animated Webp VS. GIF battle Royale!<br/>
					<span class="indent"></span><a href="https://corydowdy.com/blog/apng-vs-webp-vs-gif" target="_blank" rel="noreferrer noopener">https://corydowdy.com/blog/apng-vs-webp-vs-gif</a>
				</p>
				<p class="citation">
					<span class="italic">GIF vs APNG vs WebP,</span>Converting a GIF into another file format<br/>
					<span class="indent"></span><a href="http://littlesvr.ca/apng/gif_apng_webp.html" target="_blank" rel="noreferrer noopener">http://littlesvr.ca/apng/gif_apng_webp.html</a>
				</p>
				<p class="citation">
					<span class="italic">About WebM The WebM Project</span><br/>
					<span class="indent"></span><a href="https://www.webmproject.org/about/" target="_blank" rel="noreferrer noopener">https://www.webmproject.org/about/</a>
				</p>
				<p class="citation">
					<span class="italic">Victor Sanabria.</span>(2018).Are APNGs the GIFs of the Future?<br/>
					<span class="indent"></span><a href="https://medium.com/@victorsanabria/are-apngs-the-gifs-of-the-future-ee12b95876b0" target="_blank" rel="noreferrer noopener">https://medium.com/@victorsanabria/<wbr>are-apngs-the-gifs-of-the-future-ee12b95876b0</a>
				</p>
				<p class="citation">
					<span class="italic">Comparison of the usage statistics of WebP vs. APNG for websites.</span>(2022).<br/>
					<span class="indent"></span><a href="https://w3techs.com/technologies/comparison/im-apng,im-webp" target="_blank" rel="noreferrer noopener">https://w3techs.com/technologies/comparison/im-apng,im-webp</a>
				</p>
				<p class="citation">
					<span class="italic">Usage statistics of image file formats for websites.</span>(2022).<br/>
					<span class="indent"></span><a href="https://w3techs.com/technologies/overview/image_format" target="_blank" rel="noreferrer noopener">https://w3techs.com/technologies/overview/image_format</a>
				</p>
				<p class="citation">
					<span class="italic">Ben Phelps.</span>(2022).The Fastest GIF Does Not Exist.<br/>
					<span class="indent"></span><a href="https://www.biphelps.com/blog/The-Fastest-GIF-Does-Not-Exist" target="_blank" rel="noreferrer noopener">https://www.biphelps.com/blog/<wbr>The-Fastest-GIF-Does-Not-Exist</a>
				</p>

					
					
					
			</section>

		</main>
		<?php
            include("footer.inc");
        ?>
	</body>
</html>

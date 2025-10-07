/**
 * React hook that is used to mark the block wrapper element.
 * It provides all the necessary props like the class name.
 *
 * @see https://developer.wordpress.org/block-editor/reference-guides/packages/packages-block-editor/#useblockprops
 */
import { useBlockProps, RichText } from '@wordpress/block-editor';

/**
 * The save function defines the way in which the different attributes should
 * be combined into the final markup, which is then serialized by the block
 * editor into `post_content`.
 *
 * @see https://developer.wordpress.org/block-editor/reference-guides/block-api/block-edit-save/#save
 *
 * @return {Element} Element to render.
 */
export default function save({ attributes }) {
	const { titleOne, tabContentOne, titleTwo, tabContentTwo, titleThree, tabContentThree, titleFour, tabContentFour } = attributes;

	return (
		<div {...useBlockProps.save()}>
      <div className='impact-tab'  style={{ '--tab-background': '#9B2246' }} data-tab-num="1">
        {titleOne && (
          <RichText.Content
            tagName="h3"
            className="tab-header-one"
            value={titleOne}
          />
        )}
        {tabContentOne && (
          <RichText.Content
            tagName="div"
            className="tab-content-one"
            value={tabContentOne}
          />
        )}
      </div>
      <div className='impact-tab' style={{ '--tab-background': '#D17829' }} data-tab-num="2">
			{titleTwo && (
				<RichText.Content
					tagName="h3"
					className="tab-header-two"
					value={titleTwo}
				/>
			)}
			{tabContentTwo && (
				<RichText.Content
					tagName="div"
					className="tab-content-two"
					value={tabContentTwo}
				/>
			)}
      </div>
      <div className='impact-tab' style={{ '--tab-background': '#001777' }} data-tab-num="3">
			{titleThree && (
				<RichText.Content
					tagName="h3"
					className="tab-header-three"
					value={titleThree}
				/>
			)}
			{tabContentThree && (
				<RichText.Content
					tagName="div"
					className="tab-content-three"
					value={tabContentThree}
				/>
			)}
      </div>
      <div className='impact-tab' style={{ '--tab-background': '#00826E' }} data-tab-num="4">
			{titleFour && (
				<RichText.Content
					tagName="h3"
					className="tab-header-four"
					value={titleFour}
				/>
			)}
			{tabContentFour && (
				<RichText.Content
					tagName="div"
					className="tab-content-four"
					value={tabContentFour}
				/>
			)}
      </div>
		</div>
	);
}
import React from 'react';
import { __ } from '@wordpress/i18n';
import SeoAnalysisCheckItem from '../../seo-analysis-check-item';
import { createInterpolateElement } from '@wordpress/element';

export default class SeoAnalysisCheckMetadescHandcraft extends React.Component {
	static defaultProps = {
		data: {},
		onIgnore: () => false,
		onUnignore: () => false,
	};

	render() {
		const { data, onIgnore, onUnignore } = this.props;

		return (
			<SeoAnalysisCheckItem
				id="metadesc-handcraft"
				ignored={data.ignored}
				status={data.status}
				recommendation={this.getRecommendation()}
				statusMsg={this.getStatusMessage()}
				moreInfo={this.getMoreInfo()}
				onIgnore={onIgnore}
				onUnignore={onUnignore}
			/>
		);
	}

	getRecommendation() {
		const { state } = this.props.data.result;

		return (
			<p>
				{!state
					? createInterpolateElement(
							__(
								'We have detected that your meta description is autogenerated. We recommend crafting a custom description that includes relevant information about the page/post content. It is also a good practice to have your focus keyword in the meta description and keep its length between <strong>120 -160</strong> characters.',
								'wds'
							),
							{
								strong: <strong />,
							}
					  )
					: __(
							"You've handcrafted the meta description of this page. Excellent!",
							'wds'
					  )}
			</p>
		);
	}

	getStatusMessage() {
		const { state } = this.props.data.result;

		return !state
			? __('Your meta description is autogenerated', 'wds')
			: __('Your meta description is handcrafted', 'wds');
	}

	getMoreInfo() {
		return (
			<p>
				{createInterpolateElement(
					__(
						"You can think of the meta description as the summary of your page content. Handcrafting the meta description's main purpose is to increase your page's click-through rate on search engine result pages. Following the best practices when crafting the meta description increases the probability of displaying it on search engine result pages right after your page title. Learn more about <a>meta descriptions and best practices</a>.",
						'wds'
					),
					{
						a: (
							<a
								href="https://developers.google.com/search/docs/appearance/snippet#meta-description"
								target="_blank"
								rel="noreferrer"
							/>
						),
					}
				)}
			</p>
		);
	}
}

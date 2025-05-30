import React from 'react';
import ConfigItem from './config-item';
import { __, sprintf } from '@wordpress/i18n';
import { createInterpolateElement } from '@wordpress/element';
import Button from '../button';
import ConfigValues from '../../es6/config-values';
import Notice from '../notices/notice';

export default class ConfigsWidget extends React.Component {
	static defaultProps = {
		configs: {},
		onSave: () => false,
		onApply: () => false,
		onUpdate: () => false,
		onDownload: () => false,
		onDelete: () => false,
	};

	render() {
		const configs = this.getConfigs();
		const configsCount = Object.keys(configs).length;
		const configsExist = !!configsCount;

		return (
			<div className="sui-box">
				<div className="sui-box-header">
					<h2 className="sui-box-title">
						<span
							className="sui-icon-wrench-tool"
							aria-hidden="true"
						/>{' '}
						{__('Preset Configs', 'wds')}
					</h2>

					{configsExist && (
						<div className="sui-actions-left">
							<span className="sui-tag">{configsCount}</span>
						</div>
					)}
				</div>

				<div className="sui-box-body">
					<div id="wds-configs-list">
						<div id="wds-configs-list-inner">
							<p>
								{__(
									'Use configs to save preset configurations of your settings.',
									'wds'
								)}
							</p>

							{!configsExist && (
								<Notice
									type="info"
									message={createInterpolateElement(
										sprintf(
											// translators: %s: plugin title
											__(
												'You don’t have any available config. Save preset configurations of <strong>%s</strong>’s settings, then upload and apply them to your other sites in just a few clicks!',
												'wds'
											),
											ConfigValues.get(
												'plugin_title',
												'admin'
											)
										),
										{ strong: <strong /> }
									)}
								/>
							)}

							{configsExist && (
								<div className="sui-accordion sui-accordion-flushed">
									{Object.keys(configs).map((configKey) => {
										const config = configs[configKey];

										return (
											<ConfigItem
												{...config}
												key={config.id}
												showDescription={false}
												showApplyButton={false}
												showDate={false}
												onApply={() =>
													this.props.onApply(
														config.id
													)
												}
												onUpdate={() =>
													this.props.onUpdate(
														config.id
													)
												}
												onDownload={() =>
													this.props.onDownload(
														config.id
													)
												}
												onDelete={() =>
													this.props.onDelete(
														config.id
													)
												}
											/>
										);
									})}
								</div>
							)}

							<div
								style={{
									display: 'flex',
									justifyContent: 'space-between',
									marginTop: '30px',
								}}
							>
								<Button
									color="blue"
									text={__('Save Config', 'wds')}
									icon="sui-icon-save"
									onClick={() => this.props.onSave()}
								/>

								<a
									href={ConfigValues.get(
										'manage_url',
										'config'
									)}
									className="sui-button sui-button-ghost"
								>
									<span
										className="sui-icon-wrench-tool"
										aria-hidden="true"
									/>
									{__('Manage Configs', 'wds')}
								</a>
							</div>
						</div>
					</div>
				</div>
			</div>
		);
	}

	getConfigs() {
		return this.props.configs || {};
	}
}

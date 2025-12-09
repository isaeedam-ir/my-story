<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Elementor oEmbed Widget.
 *
 * Elementor widget that inserts an embbedable content into the page, from any given URL.
 *
 * @since 1.1.2
 */
class My_Story_Widget extends \Elementor\Widget_Base {

	/**
	 * Get widget name.
	 *
	 * Retrieve oEmbed widget name.
	 *
	 * @since 1.1.2
	 * @access public
	 * @return string Widget name.
	 */
	public function get_name(): string {
		return 'my_story_widget';
	}

	/**
	 * Get widget title.
	 *
	 * Retrieve oEmbed widget title.
	 *
	 * @since 1.1.2
	 * @access public
	 * @return string Widget title.
	 */
	public function get_title(): string {
		return esc_html__( 'My Story Widget', 'my-story' );
	}

	/**
	 * Get widget icon.
	 *
	 * Retrieve oEmbed widget icon.
	 *
	 * @since 1.1.2
	 * @access public
	 * @return string Widget icon.
	 */
	public function get_icon(): string {
		return 'eicon-counter-circle';
	}

	/**
	 * Get widget categories.
	 *
	 * Retrieve the list of categories the oEmbed widget belongs to.
	 *
	 * @since 1.1.2
	 * @access public
	 * @return array Widget categories.
	 */
	public function get_categories(): array {
		return [ 'my-story' ];
	}

	/**
	 * Get widget keywords.
	 *
	 * Retrieve the list of keywords the oEmbed widget belongs to.
	 *
	 * @since 1.1.2
	 * @access public
	 * @return array Widget keywords.
	 */
	public function get_keywords(): array {
		return ['story', 'My'];
	}

	/**
	 * Get widget script.
	 *
	 * @since 1.1.2
	 * @access public
	 * @return array Widget Script.
	 */
    public function get_script_depends(): array {
		return [ 'my-story' ];
	}

    /**
	 * Get widget styles.
	 *
	 * @since 1.1.2
	 * @access public
	 * @return array Widget Styles.
	 */
    public function get_style_depends(): array {
		return [ 'zuck-styles', 'snapgram' ];
	}

	/**
	 * Get custom help URL.
	 *
	 * Retrieve a URL where the user can get more information about the widget.
	 *
	 * @since 1.1.2
	 * @access public
	 * @return string Widget help URL.
	 */
	public function get_custom_help_url(): string {
		return 'https://isaeedam.ir/#contact';
	}

	/**
	 * Whether the widget requires inner wrapper.
	 *
	 * Determine whether to optimize the DOM size.
	 *
	 * @since 1.1.2
	 * @access protected
	 * @return bool Whether to optimize the DOM size.
	 */
	public function has_widget_inner_wrapper(): bool {
		return false;
	}

	/**
	 * Whether the element returns dynamic content.
	 *
	 * Determine whether to cache the element output or not.
	 *
	 * @since 1.1.2
	 * @access protected
	 * @return bool Whether to cache the element output.
	 */
	protected function is_dynamic_content(): bool {
		return false;
	}

	/**
	 * Register oEmbed widget controls.
	 *
	 * Add input fields to allow the user to customize the widget settings.
	 *
	 * @since 1.1.2
	 * @access protected
	 */
	protected function register_controls(): void {

        $this->start_controls_section(
            'content_section',
            [
                'label' => esc_html__('Stories', 'my-story'),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );

		$this->add_control(
			'direction',
			[
				'label' => esc_html__( 'Direction', 'my-story' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'default' => 'true',
				'options' => [
					'true' => esc_html__( 'RTL (right-to-left)', 'my-story' ),
					'false'  => esc_html__( 'LTR (left-to-right)', 'my-story' ),
				],
			]
		);

        $repeater = new \Elementor\Repeater();

        $repeater->add_control(
            'title',
            [
                'label' => __('Title', 'my-story'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'placeholder' => __('Story Main Title', 'my-story'),
                'default' => __('My Story', 'my-story'),
            ]
        );
        $repeater->add_control(
            'img_pre',
            [
                'label' => __('Story Preview Thumbnail', 'my-story'),
                'type' => \Elementor\Controls_Manager::MEDIA,
                'default' => [
					'url' => \Elementor\Utils::get_placeholder_image_src(),
				]
            ]
        );
        $repeater->add_control(
            'time',
            [
                'label' => __('Duration of each story (seconds)', 'my-story'),
                'type' => \Elementor\Controls_Manager::NUMBER,
                'min' => 1,
                'max' => 600,
                'step' => 1,
                'default' => 5,
            ]
        );
        $repeater->add_control(
            'hr',
            [
                'type' => \Elementor\Controls_Manager::DIVIDER,
            ]
        );

        $repeater->add_control(
            'type',
            [
                'label' => __('Story Content', 'my-story'),
                'type' => \Elementor\Controls_Manager::CHOOSE,
                'options' => [
                    'image' => [
                        'title' => __('Image', 'my-story'),
                        'icon' => 'eicon-image-bold',
                    ],
                    'video' => [
                        'title' => __('Video', 'my-story'),
                        'icon' => 'eicon-video-camera',
                    ],
                ],
                'default' => 'image',
                'toggle' => false,
            ]
        );
        $repeater->add_control(
            'gallery',
            [
                'label' => __('Story Images', 'my-story'),
                'type' => \Elementor\Controls_Manager::GALLERY,
                'show_label' => true,
                'default' => [],
                'condition' => [
                    'type' => 'image',
                ],
            ]
        );
        $repeater->add_control(
            'link_video',
            [
                'label' => __('Video Link', 'my-story'),
                'type' => \Elementor\Controls_Manager::URL,
                'options' => ['url', 'is_external', 'nofollow'],
                'default' => [
                    'url' => '',
                    'is_external' => false,
                    'nofollow' => false,
                ],
                'label_block' => true,
                'condition' => [
                    'type' => 'video',
                ],
            ]
        );
        $repeater->add_control(
            'hr2',
            [
                'type' => \Elementor\Controls_Manager::DIVIDER,
            ]
        );
        $repeater->add_control(
            'title_btn',
            [
                'label' => __('Story Link Button Text', 'my-story'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => __('Click Here', 'my-story'),
            ]
        );
        $repeater->add_control(
            'link_story',
            [
                'label' => __('Story Link', 'my-story'),
                'type' => \Elementor\Controls_Manager::URL,
                'options' => ['url', 'is_external', 'nofollow'],
                'default' => [
                    'url' => '',
                    'is_external' => true,
                    'nofollow' => false,
                ],
                'label_block' => true,
            ]
        );

        $this->add_control(
            'stories',
            [
                'label' => __('My Stories', 'my-story'),
                'type' => \Elementor\Controls_Manager::REPEATER,
                'fields' => $repeater->get_controls(),
                'default' => [
                    [
                        'title' => __('Story Title', 'my-story'),
                    ],
                ],
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'dispaly_section',
            [
                'label' => esc_html__( 'Display Settings', 'my-story' ),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );

		$this->add_control(
			'show_title',
			[
				'label' => esc_html__( 'Story Title', 'my-story' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Show', 'my-story' ),
				'label_off' => esc_html__( 'Hide', 'my-story' ),
				'return_value' => 'yes',
				'default' => 'yes',
				'separator' => 'after'
			]
		);
        $this->add_control(
			'show_popup_preview',
			[
				'label' => esc_html__( 'Story Preview Thumbnail', 'my-story' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Show', 'my-story' ),
				'label_off' => esc_html__( 'Hide', 'my-story' ),
				'return_value' => 'yes',
				'default' => 'yes',
			]
		);
        $this->add_control(
			'show_popup_title',
			[
				'label' => esc_html__( 'Story Preview Title', 'my-story' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Show', 'my-story' ),
				'label_off' => esc_html__( 'Hide', 'my-story' ),
				'return_value' => 'yes',
				'default' => 'yes',
			]
		);
        $this->add_control(
			'show_timestamp',
			[
				'label' => esc_html__( 'Story Preview Timestamp', 'my-story' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Show', 'my-story' ),
				'label_off' => esc_html__( 'Hide', 'my-story' ),
				'return_value' => 'yes',
				'default' => 'yes',
			]
		);

        $this->end_controls_section();

        $this->start_controls_section(
            'settings_section',
            [
                'label' => esc_html__( 'General Settings', 'my-story' ),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );

		$this->add_control(
			'avatars',
			[
				'label' => esc_html__( 'Avatars', 'my-story' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Yes', 'my-story' ),
				'label_off' => esc_html__( 'No', 'my-story' ),
				'default' => 'yes',
				'description' => esc_html__('Show user photo instead of the first story item preview?', 'my-story')
			]
		);

		$this->add_control(
			'back_button',
			[
				'label' => esc_html__( 'Back Button', 'my-story' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Yes', 'my-story' ),
				'label_off' => esc_html__( 'Hide', 'my-story' ),
				'default' => 'yes',
				'description' => esc_html__('Add a back button to close the story viewer? (on smaller screens)', 'my-story')
			]
		);

		$this->add_control(
			'cube_effect',
			[
				'label' => esc_html__( 'Cube Effect', 'my-story' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Yes', 'my-story' ),
				'label_off' => esc_html__( 'No', 'my-story' ),
				'default' => 'yes',
				'description' => esc_html__('Enable the 3D cube effect when sliding between stories?', 'my-story')
			]
		);

        $this->add_control(
			'more_options',
			[
				'label' => esc_html__( 'Additional Options', 'my-story' ),
				'type' => \Elementor\Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_control(
			'auto_full_screen',
			[
				'label' => esc_html__( 'Auto Full Screen', 'my-story' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Yes', 'my-story' ),
				'label_off' => esc_html__( 'No', 'my-story' ),
				'default' => 'no',
				'description' => esc_html__('Should stories automatically open in full screen on mobile?', 'my-story')
			]
		);

		$this->add_control(
			'back_native',
			[
				'label' => esc_html__( 'Back Native Button', 'my-story' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Yes', 'my-story' ),
				'label_off' => esc_html__( 'No', 'my-story' ),
				'default' => 'yes',
				'description' => esc_html__('Exit story mode when the mobile back button is pressed?', 'my-story'),
			]
		);

		$this->add_control(
			'previous_tap',
			[
				'label' => esc_html__( 'Previous Tap', 'my-story' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Yes', 'my-story' ),
				'label_off' => esc_html__( 'No', 'my-story' ),
				'default' => 'yes',
				'description' => esc_html__('Use the left third of the screen to navigate to the previous item when tapping the story?', 'my-story'),
			]
		);

		$this->add_control(
			'pagination_arrows',
			[
				'label' => esc_html__( 'Show Pagination Arrows', 'my-story' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Yes', 'my-story' ),
				'label_off' => esc_html__( 'No', 'my-story' ),
				'default' => 'yes',
			]
		);
        
        $this->end_controls_section();


        $this->start_controls_section(
            'style_section',
            [
                'label' => esc_html__( 'Style Section', 'my-story' ),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name' => 'content_typography',
				'selector' => '.info .name, .info .time, #zuck-modal-content .story-viewer .tip',
                'condition' => [
                    'show_title' => 'yes',
                ],
			]
		);

        $this->add_group_control(
			\Elementor\Group_Control_Border::get_type(),
			[
				'name' => 'border',
				'selector' => '{{WRAPPER}} .stories.carousel .story>.item-link>.item-preview img',
			]
		);

        $this->add_group_control(
			\Elementor\Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'box_shadow',
				'selector' => '{{WRAPPER}} .stories.snapgram .story > .item-link>.item-preview',
			]
		);

        $this->add_control(
			'img-border-radius',
			[
				'label' => esc_html__( 'Image Border Radius', 'my-story' ),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em', 'rem', 'custom' ],
				'selectors' => [
					'{{WRAPPER}} .stories.carousel .story>.item-link>.item-preview img' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

        $this->add_control(
			'border-radius',
			[
				'label' => esc_html__( 'Background Border Radius', 'my-story' ),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em', 'rem', 'custom' ],
				'selectors' => [
					'{{WRAPPER}} .stories.snapgram .story > .item-link>.item-preview' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

        $this->add_group_control(
			\Elementor\Group_Control_Background::get_type(),
			[
				'name' => 'background',
				'types' => [ 'classic', 'gradient' ],
				'selector' => '{{WRAPPER}} .stories.snapgram .story > .item-link>.item-preview',
			]
		);

        $this->add_control(
			'padding',
			[
				'label' => esc_html__( 'Padding', 'my-story' ),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em', 'rem', 'custom' ],
				'selectors' => [
					'{{WRAPPER}} .stories.snapgram .story > .item-link>.item-preview' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

        $this->end_controls_section();

	}

	/**
	 * Render oEmbed widget output on the frontend.
	 *
	 * Written in PHP and used to generate the final HTML.
	 *
	 * @since 1.1.2
	 * @access protected
	 */
	protected function render(): void {

		$settings = $this->get_settings_for_display();
		$stories = $settings['stories'];

		if ( 'yes' !== $settings['show_title'] ) {
			echo '<style>.stories.carousel .story>.item-link>.info{display:none;}</style>';
		}
		if ( 'yes' !== $settings['show_popup_preview'] ) {
			echo '<style>body #zuck-modal #zuck-modal-content .story-viewer .head .item-preview{display:none;}</style>';
		}
		if ( 'yes' !== $settings['show_popup_title'] ) {
			echo '<style>body #zuck-modal-content .story-viewer .head .left .info .name{display:none;}</style>';
		}
		if ( 'yes' !== $settings['show_timestamp'] ) {
			echo '<style>body #zuck-modal-content .story-viewer .head .info span.time{display:none;}</style>';
		}
		
		$back_native = $settings['back_native'] === 'yes' ? 'true' : 'false';
		$previous_tap = $settings['previous_tap'] === 'yes' ? 'true' : 'false';
		$auto_full_screen = $settings['auto_full_screen'] === 'yes' ? 'true' : 'false';
		$avatars = $settings['avatars'] === 'yes' ? 'true' : 'false';
		$pagination_arrows = $settings['pagination_arrows'] === 'yes' ? 'true' : 'false';
		$cube_effect = $settings['cube_effect'] === 'yes' ? 'true' : 'false';
		$direction = $settings['direction'];
		$back_button = $settings['back_button'] === 'yes' ? 'true' : 'false';

		?>
        <section class="my-story" data-back-native="<?php echo esc_attr($back_native); ?>"
			data-previous-tap="<?php echo esc_attr($previous_tap); ?>" data-auto-full-screen="<?php echo esc_attr($auto_full_screen); ?>"
			data-avatars="<?php echo esc_attr($avatars); ?>" data-pagination-arrows="<?php echo esc_attr($pagination_arrows); ?>"
			data-cube-effect="<?php echo esc_attr($cube_effect); ?>" data-direction="<?php echo esc_attr($direction); ?>"
			data-back-button="<?php echo esc_attr($back_button); ?>">
            <div class="storiesDataContainer">
                <?php foreach ( $stories as $story ): ?>
                    <div class="storyData" data-id="<?php echo esc_attr( $story['_id'] ); ?>"
                    data-photo="<?php echo ! isset( $story['img_pre'] ) ? '' : esc_url( $story['img_pre']['url'] ); ?>"
                    data-name="<?php echo esc_attr( $story['title'] ); ?>" >
                        <?php if ( $story['type'] == 'image' ){ ?>
                        <?php foreach ($story['gallery'] as $gallery) : ?>
                            <div class="storyItem" data-id="<?php echo esc_attr($story['_id'])."-".esc_html($gallery['id']); ?>"
                            data-length="<?php echo number_format($story['time']); ?>"
                            data-type="photo"
                            data-src="<?php echo esc_url($gallery['url']); ?>"
                            data-preview="<?php echo esc_url($gallery['url']); ?>"
                            data-link="<?php echo esc_url($story['link_story']['url']); ?>"
                            data-linkText="<?php echo esc_attr($story['title_btn']); ?>" ></div>
                        <?php endforeach;
                        } else { ?>
                            <div class="storyItem" data-id="<?php echo esc_attr($story['_id']).esc_html(wp_rand()); ?>" 
                                data-type="video" data-length="0"
                                data-src="<?php echo esc_url($story['link_video']['url']); ?>"
                                data-preview="<?php echo esc_url($story['img_pre']['url']); ?>"
                                data-link="<?php echo esc_url($story['link_story']['url']); ?>"
                                data-linkText="<?php echo esc_html($story['title_btn']); ?>" >
                            </div>
                        <?php } ?>
                    </div>
                <?php endforeach; ?>
            </div>
            <div id="stories" class="storiesWrapper">
            </div>
        </section>
		<?php
	}

}

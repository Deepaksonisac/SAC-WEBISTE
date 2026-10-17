<?php
/**
 * Original website content, copied verbatim from the Next.js source.
 *
 * The theme renders these values when nothing has been saved in the dashboard
 * yet, and the SAC Companion importer uses the same data to seed WordPress.
 *
 * @package SAC
 */

defined( 'ABSPATH' ) || exit;

/**
 * Images shipped with the theme, keyed by the original public/ path.
 * Paths are relative to assets/images/.
 */
function sac_default_images() {
	return array(
		'logo'                => 'sac-logo-business-services.png',
		'about'               => 'about-control-room.png',
		'leader-ankur'        => 'leadership/ankur-gupta.jpeg',
		'leader-ankit'        => 'leadership/ankit-maheshwari.png',
		'leader-varsha'       => 'leadership/varsha-gupta.jpeg',
		'p-taj'               => 'projects/taj-sawai-man-mahal.avif',
		'p-hyatt'             => 'projects/hyatt-place.webp',
		'p-hilton'            => 'projects/hilton.avif',
		'p-westin'            => 'projects/westin-jaipur.avif',
		'p-westin-spa'        => 'projects/westin-spa-resorts.jfif',
		'p-signia'            => 'projects/signia-by-hilton.jpg',
		'p-itc'               => 'projects/itc-mementos-phase-1.jpg',
		'p-gims'              => 'gims.jpg',
		'p-ongc'              => 'projects/ongc-crew-changing-facility.jpg',
		'p-sms'               => 'projects/sms-super-specialty-hospital.avif',
		'p-sms-cardio'        => 'projects/sms-cardiology-block.jfif',
		'p-nih'               => 'projects/national-institute-homeopathy.jpg',
		'p-regency-gkp'       => 'projects/regency-hospital-gorakhpur.webp',
		'p-regency-knp'       => 'projects/regency-hospital-kanpur.webp',
		'p-oil'               => 'projects/oil-hospital.webp',
		'p-civil'             => 'projects/new-civil-hospital.jfif',
		'p-ayodhya'           => 'projects/ayodhya-airport.jpg',
		'p-utkarsh'           => 'projects/utkarsh-bank-phase-2.png',
		'p-ms-emerging'       => 'projects/ms-emerging-commercial-building.jpg',
		'p-minto'             => 'projects/minto-hall.png',
		'p-jagatpura'         => 'projects/jagatpura-world-center.jfif',
		'p-ntpc'              => 'projects/ntpc.jpg',
		'p-npcil'             => 'projects/npcil.jpg',
		'p-iocl'              => 'projects/iocl.png',
		'p-cairn'             => 'projects/cairn-india-vedanta.jpg',
		'p-hpcl'              => 'projects/hpcl.jpg',
	);
}

/**
 * Site-wide settings (SAC Settings screen). Image values reference
 * sac_default_images() keys and become attachment IDs after import.
 */
function sac_default_settings() {
	return array(
		// General & contact.
		'logo'                   => 'img:logo',
		'header_cta_label'       => 'Get a Consultation',
		'header_cta_url'         => '/contact',
		'footer_tagline'         => 'Engineering trust since 2010 — tailor-made Building Security, Management & Automation for India’s most demanding facilities.',
		'footer_location'        => 'Jaipur, Rajasthan, India',
		'phone_1'                => '+91 93529 70001',
		'phone_2'                => '+91 98290 84113',
		'email_1'                => 'ag@sacindia.co.in',
		'email_2'                => 'am@sacindia.co.in',
		'address'                => "Plot No. C-5/2, Chitrakoot Scheme,\nAjmer Road, Jaipur – 302021",
		'map_query'              => 'Chitrakoot, Ajmer Road, Jaipur, Rajasthan 302021',
		'social_linkedin'        => '#',
		'social_x'               => '#',
		'social_facebook'        => '#',
		'form_recipient'         => '',

		// Home.
		'hero_badge'             => 'Building Security, Management & Automation · Jaipur, India',
		'hero_title'             => 'Engineering Trust',
		'hero_title_highlight'   => 'Since 2010',
		'hero_text'              => 'Secure Automation Consultants designs and delivers tailor-made Building Security, Management & Automation solutions for India’s most demanding facilities.',
		'hero_btn1_label'        => 'Explore Solutions',
		'hero_btn1_url'          => '/solutions',
		'hero_btn2_label'        => 'View Our Projects',
		'hero_btn2_url'          => '/projects',
		'hero_3d'                => '1',
		'home_about_eyebrow'     => 'Who We Are',
		'home_about_title'       => 'A systems integrator engineered around your requirement',
		'home_about_text'        => 'Since 2010, Secure Automation Consultants has partnered with customers as an integral part of their requirement — engineering the right product mix to turn complex problems into future-proof, tailor-made solutions in Building Security, Management & Automation.',
		'home_about_link_label'  => 'Learn more about SAC',
		'home_about_image'       => 'img:about',
		'home_solutions_eyebrow' => 'What We Do',
		'home_solutions_title'   => 'Six integrated disciplines, one accountable partner',
		'home_solutions_link'    => 'Explore all solutions',
		'marquee_enabled'        => '0',
		'marquee_title'          => 'Trusted across India’s most demanding facilities',
		'stats'                  => array(
			array( 'value' => '50', 'suffix' => '+', 'label' => 'Team Members', 'display' => '' ),
			array( 'value' => '15', 'suffix' => '+', 'label' => 'Years of Delivery', 'display' => '' ),
			array( 'value' => '100', 'suffix' => '+', 'label' => 'Projects Delivered', 'display' => '' ),
			array( 'value' => '0', 'suffix' => '', 'label' => 'Pan-India Presence', 'display' => 'Pan-India' ),
		),

		// Shared call-to-action band.
		'cta_title'              => 'Let’s engineer your next secure facility',
		'cta_text'               => 'Tell us about your site and requirements. Our engineers will design the right mix of security, management and automation systems.',
		'cta_btn_label'          => 'Get a Consultation',
		'cta_btn_url'            => '/contact',

		// Solutions page.
		'solutions_title'        => 'End-to-end security & automation, engineered as one system',
		'solutions_intro'        => 'Six integrated disciplines, delivered by a single accountable partner. Expand each to see what we deliver.',

		// About page.
		'about_eyebrow'          => 'Company Overview',
		'about_title'            => 'Partnering as an integral part of your requirement',
		'about_p1'               => 'Secure Automation Consultants partners with customers as an integral part of their requirement — engineering the right product mix to turn complex problems into future-proof, tailor-made solutions in Building Security, Management & Automation.',
		'about_p2'               => 'Since 2010 we have designed, deployed and maintained integrated security and automation ecosystems across oil & gas, power, cement, government and smart cities, hospitality, healthcare, education and aviation — delivered by a single accountable team.',
		'about_image'            => 'img:about',
		'leadership_eyebrow'     => 'Leadership',
		'leadership_title'       => 'The people behind the engineering',
		'leadership_quote'       => '“Business is People.”',

		// Why SAC page.
		'why_title'              => 'Principles that hold up under pressure',

		// Contact page.
		'contact_success_title'  => 'Thank you',
		'contact_success_text'   => 'Your enquiry has been received. Our team will get back to you shortly to discuss your requirement.',

		// Careers page.
		'careers_eyebrow'        => 'Careers at SAC',
		'careers_title'          => 'Grow with Secure',
		'careers_title_highlight'=> 'Automation Consultants',
		'careers_p1'             => 'At Secure Automation Consultants, our people are the foundation of our success. We provide opportunities to work on challenging projects across Building Management Systems, CCTV Surveillance, Access Control, Fire Detection & Alarm, Public Address, IT Networking and integrated ELV solutions.',
		'careers_p2'             => 'Whether you are an experienced professional or developing your engineering career, SAC provides an environment where technical knowledge, responsibility and continuous learning come together.',
		'careers_btn_label'      => 'View Current Openings',
		'careers_card_title'     => 'Engineer. Learn. Grow.',
		'careers_card_text'      => 'Be part of a team delivering reliable, intelligent and future-ready technology solutions for demanding facilities and infrastructure.',
		'careers_highlights'     => array(
			array( 'value' => 'Smart', 'label' => 'Building Technologies' ),
			array( 'value' => 'Integrated', 'label' => 'ELV Solutions' ),
		),
		'benefits_eyebrow'       => 'Why Join SAC',
		'benefits_title'         => 'Build more than a career',
		'benefits_text'          => 'Grow with a team focused on engineering excellence, practical learning and delivering technology that makes facilities smarter, safer and more efficient.',
		'benefits'               => array(
			array( 'icon' => 'graduation-cap', 'title' => 'Professional Growth', 'text' => 'Build your career through real-world exposure to advanced automation, security and ELV technologies.' ),
			array( 'icon' => 'building-2', 'title' => 'Diverse Projects', 'text' => 'Work across hospitality, healthcare, commercial, industrial and infrastructure projects.' ),
			array( 'icon' => 'network', 'title' => 'Learning & Development', 'text' => 'Gain practical knowledge of leading technologies, systems and modern engineering practices.' ),
			array( 'icon' => 'users', 'title' => 'Collaborative Culture', 'text' => 'Work alongside experienced engineers, project teams and technology professionals.' ),
		),
		'openings_eyebrow'       => 'Opportunities',
		'openings_title'         => 'Current openings',
		'openings_text'          => 'Explore opportunities to join our engineering, project and technology teams.',
		'apply_eyebrow'          => 'Join Our Team',
		'apply_title'            => 'Your next opportunity starts here',
		'apply_text'             => 'If you are passionate about smart buildings, automation, security systems and engineering excellence, we would like to hear from you.',
		'apply_box_title'        => 'Don’t see the right position?',
		'apply_box_text'         => 'Share your profile with us. Suitable candidates may be considered for future opportunities at Secure Automation Consultants.',
		'apply_form_title'       => 'Apply for an opportunity',
		'apply_form_text'        => 'Complete the form below and share your professional profile with our team.',
		'careers_cta_title'      => 'Ready to build your career with SAC?',
		'careers_cta_text'       => 'Join a team engineering secure, intelligent and future-ready facilities through integrated technology.',
		'careers_success_title'  => 'Application received',
		'careers_success_text'   => 'Thank you for your interest in SAC. Our team will review your profile and contact you if there is a suitable opportunity.',
	);
}

/**
 * The seven pages, their header content and SEO metadata.
 */
function sac_default_pages() {
	return array(
		'home'      => array(
			'title'           => 'Home',
			'template'        => '',
			'eyebrow'         => '',
			'heading'         => '',
			'subtitle'        => '',
			'seo_title'       => 'Secure Automation Consultants | Building Security, Management & Automation',
			'seo_description' => 'Jaipur-based systems integrator delivering CCTV/IP surveillance, access control, fire detection, BMS, IT networking, and public address solutions to India’s most demanding facilities since 2010.',
		),
		'solutions' => array(
			'title'           => 'Solutions',
			'template'        => 'page-solutions.php',
			'eyebrow'         => 'Solutions',
			'heading'         => 'Security & automation, engineered as one system',
			'subtitle'        => 'Six integrated disciplines delivered by a single accountable partner — from surveillance and access control to fire, BMS, networking and public address.',
			'seo_title'       => 'Solutions | Secure Automation Consultants',
			'seo_description' => 'IP video surveillance, access control, fire detection & suppression, building management systems, IT networking, and PAGA/PIDS — engineered and delivered as one integrated system.',
		),
		'projects'  => array(
			'title'           => 'Projects',
			'template'        => 'page-projects.php',
			'eyebrow'         => 'Trusted Across Mission-Critical Environments',
			'heading'         => 'Trusted on India\'s most critical sites',
			'subtitle'        => 'Explore SAC’s experience across healthcare, hospitality, infrastructure and commercial facilities — delivering reliable integrated security, ELV and building automation solutions.',
			'seo_title'       => 'Projects | Secure Automation Consultants',
			'seo_description' => 'Flagship SAC deployments across energy & power, cement & manufacturing, hospitality, government & smart cities, healthcare, education, aviation and infrastructure.',
		),
		'about'     => array(
			'title'           => 'About',
			'template'        => 'page-about.php',
			'eyebrow'         => 'About SAC',
			'heading'         => 'Engineering trust since 2010',
			'subtitle'        => 'A Jaipur-based systems integrator built around a simple idea — that the best security and automation is engineered around your requirement, not sold from a catalogue.',
			'seo_title'       => 'About | Secure Automation Consultants',
			'seo_description' => 'Since 2010, SAC has engineered tailor-made Building Security, Management & Automation solutions for India’s most demanding facilities. Meet the team behind the engineering.',
		),
		'why-sac'   => array(
			'title'           => 'Why SAC',
			'template'        => 'page-why-sac.php',
			'eyebrow'         => 'Why SAC',
			'heading'         => 'Business is people',
			'subtitle'        => 'Our work is engineered on three value pillars that hold up under pressure — a people-first model, disciplined value for money, and a culture built to last.',
			'seo_title'       => 'Why SAC | Secure Automation Consultants',
			'seo_description' => 'People-first business, value for money, and a culture of Integrity, Excellence, Teamwork and Accountability — the principles behind every SAC engagement.',
		),
		'careers'   => array(
			'title'           => 'Careers',
			'template'        => 'page-careers.php',
			'eyebrow'         => 'Careers',
			'heading'         => 'Build the future with us',
			'subtitle'        => 'Join Secure Automation Consultants and build your career while delivering intelligent building automation, integrated security, ELV and smart infrastructure solutions.',
			'seo_title'       => 'Careers | Secure Automation Consultants',
			'seo_description' => 'Explore career opportunities at Secure Automation Consultants in building automation, ELV, BMS, CCTV, access control, fire detection and integrated security solutions.',
		),
		'contact'   => array(
			'title'           => 'Contact',
			'template'        => 'page-contact.php',
			'eyebrow'         => 'Contact',
			'heading'         => 'Let\'s engineer your next secure facility',
			'subtitle'        => 'Tell us about your site and requirements. Our team responds to every enquiry within one business day.',
			'seo_title'       => 'Contact | SAC — Secure Automation Consultants',
			'seo_description' => 'Get in touch with SAC for security, surveillance and building automation projects. Based in Jaipur, serving critical facilities across India.',
		),
	);
}

/** Navigation as it appears in the original header and footer. */
function sac_default_menus() {
	return array(
		'primary'         => array(
			array( 'Home', 'home' ),
			array( 'Solutions', 'solutions' ),
			array( 'Projects', 'projects' ),
			array( 'About', 'about' ),
			array( 'Why SAC', 'why-sac' ),
			array( 'Careers', 'careers' ),
			array( 'Contact', 'contact' ),
		),
		'footer_quick'    => array(
			array( 'Home', 'home' ),
			array( 'About', 'about' ),
			array( 'Solutions', 'solutions' ),
			array( 'Projects', 'projects' ),
			array( 'Why SAC', 'why-sac' ),
			array( 'Careers', 'careers' ),
			array( 'Contact', 'contact' ),
		),
		'footer_services' => array(
			array( 'IP Video Surveillance', '/solutions#ip-video-surveillance' ),
			array( 'Access Control', '/solutions#access-control' ),
			array( 'Fire Detection & Suppression', '/solutions#fire-detection' ),
			array( 'Building Management Systems', '/solutions#building-management' ),
			array( 'IT Networking & Wi-Fi', '/solutions#it-networking' ),
			array( 'PAGA & PIDS', '/solutions#paga-pids' ),
		),
	);
}

function sac_default_solutions() {
	return array(
		array(
			'anchor'        => 'ip-video-surveillance',
			'icon'          => 'video',
			'title'         => 'IP Video Surveillance & Analytics',
			'short_label'   => 'IP Video Surveillance',
			'summary'       => 'On-site monitoring, hosted video and PTZ integration with intelligent video analytics.',
			'details_title' => '',
			'details'       => array( 'On-site and cloud-hosted video management', 'PTZ and multi-sensor camera integration', 'AI-driven video analytics and event detection', 'Explosion-proof cameras for hazardous zones' ),
		),
		array(
			'anchor'        => 'access-control',
			'icon'          => 'key-round',
			'title'         => 'Access Control Systems',
			'short_label'   => 'Access Control',
			'summary'       => 'Turnstiles, flap & boom barriers, vehicle access management, RFID guard tour.',
			'details_title' => 'Why an Access Control System',
			'details'       => array( 'Real-time remote control of access', 'Shrinkage reduction and asset protection', 'Workplace-safety enforcement', 'Reduced rekeying costs', 'Robust data security', 'Attendance and event reporting' ),
		),
		array(
			'anchor'        => 'fire-detection',
			'icon'          => 'flame',
			'title'         => 'Fire Detection & Suppression',
			'short_label'   => 'Fire Detection & Suppression',
			'summary'       => 'Aspirating smoke detection and gas-based suppression for critical facilities.',
			'details_title' => '',
			'details'       => array( 'Aspirating (VESDA) smoke detection', 'Gas-based suppression systems', 'Addressable fire alarm networks', 'Integration with BMS and evacuation' ),
		),
		array(
			'anchor'        => 'building-management',
			'icon'          => 'building-2',
			'title'         => 'Building Management Systems',
			'short_label'   => 'Building Management',
			'summary'       => 'Centralised BMS integrating HVAC, lighting, energy and life-safety systems.',
			'details_title' => '',
			'details'       => array( 'HVAC, lighting and energy automation', 'Centralised monitoring and control', 'Life-safety system integration', 'Energy optimisation and reporting' ),
		),
		array(
			'anchor'        => 'it-networking',
			'icon'          => 'wifi',
			'title'         => 'IT Networking & Wi-Fi',
			'short_label'   => 'IT Networking & Wi-Fi',
			'summary'       => 'Structured cabling, enterprise networking and resilient Wi-Fi infrastructure.',
			'details_title' => '',
			'details'       => array( 'Structured cabling and data networking', 'Enterprise-grade Wi-Fi coverage', 'Network security and segmentation', 'Redundant, high-availability design' ),
		),
		array(
			'anchor'        => 'paga-pids',
			'icon'          => 'radio',
			'title'         => 'Audio-Video, PAGA & PIDS',
			'short_label'   => 'PAGA & PIDS',
			'summary'       => 'Public address, general alarm and perimeter intrusion detection systems.',
			'details_title' => '',
			'details'       => array( 'Public Address & General Alarm (PAGA)', 'Perimeter Intrusion Detection (PIDS)', 'Conference and auditorium AV', 'Integrated mass notification' ),
		),
	);
}

/** Industry filter categories, in the original filter order. */
function sac_default_industries() {
	return array(
		'hospitality'                 => 'Hospitality',
		'healthcare'                  => 'Healthcare',
		'infrastructure-commercial'   => 'Infrastructure & Commercial',
		'industrial'                  => 'Industrial',
	);
}

function sac_default_projects() {
	$h  = 'hospitality';
	$hc = 'healthcare';
	$ic = 'infrastructure-commercial';
	$in = 'industrial';
	return array(
		array( 'Taj Sawai Man Mahal (Rambagh)', 'Jaipur', $h, 'p-taj', 'Hospitality ELV Solutions' ),
		array( 'Hyatt Place', 'Jaipur', $h, 'p-hyatt', 'Hospitality ELV Solutions' ),
		array( 'Hilton', 'Congo', $h, 'p-hilton', 'Hospitality ELV Solutions' ),
		array( 'Westin Jaipur', 'Jaipur', $h, 'p-westin', 'Hospitality ELV Solutions' ),
		array( 'Westin Spa & Resorts', 'Jaipur', $h, 'p-westin-spa', 'Hospitality ELV Solutions' ),
		array( 'Signia By Hilton', 'Jaipur', $h, 'p-signia', 'Hospitality ELV Solutions' ),
		array( 'ITC Mementos', 'Jaipur', $h, 'p-itc', 'Hospitality ELV Solutions' ),
		array( 'Geetanjali Institute of Medical Sciences (GIMS)', 'Jaipur', $h, 'p-gims', 'Hospitality ELV Solutions' ),
		array( 'ONGC Crew Changing Facility', 'Mumbai', $h, 'p-ongc', 'ELV & Integrated Systems' ),
		array( 'SMS Super Specialty Hospital', 'Jaipur', $hc, 'p-sms', 'Healthcare ELV Solutions' ),
		array( 'SMS Cardiology Block', 'Jaipur', $hc, 'p-sms-cardio', 'Healthcare ELV Solutions' ),
		array( 'National Institute of Homeopathy', 'Narela, Delhi', $hc, 'p-nih', 'Healthcare ELV Solutions' ),
		array( 'Regency Hospital', 'Gorakhpur', $hc, 'p-regency-gkp', 'Healthcare ELV Solutions' ),
		array( 'Regency Hospital', 'Kanpur', $hc, 'p-regency-knp', 'Healthcare ELV Solutions' ),
		array( 'Oil India Limited', 'Duliajan, Assam', $hc, 'p-oil', 'Healthcare ELV Solutions' ),
		array( 'New Civil Hospital', 'Palitana Gujrat', $hc, 'p-civil', 'Healthcare ELV Solutions' ),
		array( 'Ayodhya Airport', 'Ayodhya', $ic, 'p-ayodhya', 'Infrastructure ELV Solutions' ),
		array( 'Utkarsh Small Finance Bank', 'Varanasi', $ic, 'p-utkarsh', 'Commercial ELV Solutions' ),
		array( 'MS Emerging Commercial Building', 'Jaipur', $ic, 'p-ms-emerging', 'Commercial Building Solutions' ),
		array( 'Minto Hall', 'Bhopal', $ic, 'p-minto', 'Integrated ELV Solutions' ),
		array( 'Jagatpura World Center', 'Jaipur', $ic, 'p-jagatpura', 'Commercial Building Solutions' ),
		array( 'NTPC', 'India', $in, 'p-ntpc', 'Industrial ELV Solutions' ),
		array( 'NPCIL', 'India', $in, 'p-npcil', 'Industrial ELV Solutions' ),
		array( 'IOCL', 'India', $in, 'p-iocl', 'Industrial ELV Solutions' ),
		array( 'Cairn India Vedanta', 'India', $in, 'p-cairn', 'Industrial ELV Solutions' ),
		array( 'HPCL', 'India', $in, 'p-hpcl', 'Industrial ELV Solutions' ),
	);
}

function sac_default_leaders() {
	return array(
		array(
			'name'  => 'Ankur Gupta',
			'role'  => 'Key Decision Maker',
			'image' => 'leader-ankur',
			'bio'   => 'An “Engineer” with “non-Engineering” grooming whose love for technology brought him to Low Voltage System Integration. With his team of 50+ at SAC, he leads consulting and design of LV solutions for high-rise buildings and industries, keeping the motto “Business is People” at a high state.',
		),
		array(
			'name'  => 'Ankit Maheshwari',
			'role'  => 'Key Decision Maker',
			'image' => 'leader-ankit',
			'bio'   => 'An Engineer by qualification whose passion for business brought him to Low Voltage System Integration. With his team of 50+ at SAC, he leads consulting and design of LV solutions across various industries, keeping the motto “Business is People” at a high state.',
		),
		array(
			'name'  => 'Varsha Gupta',
			'role'  => 'Director, Commercial & Administration',
			'image' => 'leader-varsha',
			'bio'   => 'A passionate leader with 19+ years across IT, Telecom, Finance & Technology. As Chief Strategist she guides her 50+ team in consulting and designing Low Voltage solutions for high-rise buildings and industries, her entrepreneurial spirit taking SAC to new heights.',
		),
	);
}

function sac_default_pillars() {
	return array(
		array( 'icon' => 'users', 'title' => 'Business is People', 'body' => 'A people-first business model built on our organizational intellectual capital and deep engagement with every customer.' ),
		array( 'icon' => 'scale', 'title' => 'Value for Money', 'body' => 'Governance, financial discipline, performance management, customer focus and planning aimed at maximum value — not just lowest cost.' ),
		array( 'icon' => 'gem', 'title' => 'People & Value', 'body' => 'A culture built on Integrity, Excellence, Teamwork and Accountability in everything we design and deliver.' ),
	);
}

function sac_default_jobs() {
	return array(
		array(
			'title'            => 'Planning Engineer – ELV Systems',
			'badge'            => 'Now Hiring',
			'location'         => 'Jaipur, Rajasthan',
			'experience'       => '3–5 Years',
			'department'       => 'Projects / ELV',
			'employment'       => 'Full Time',
			'knowledge'        => 'Strong understanding of BMS, CCTV, Access Control, Fire Alarm, Public Address and IT Networking systems.',
			'skills'           => array( 'BMS', 'CCTV', 'Access Control', 'Fire Alarm', 'Public Address', 'IT Networking' ),
			'responsibilities' => array(
				'Project planning, scheduling and execution coordination',
				'Material planning, tracking and site coordination',
				'BMS, CCTV, Access Control, Fire Alarm and PA system coordination',
				'Project documentation and progress monitoring',
				'Testing & commissioning coordination',
				'Coordination with clients, consultants and project teams',
			),
		),
	);
}

/** Client names for the optional marquee: unique project clients, as in the original component. */
function sac_default_clients() {
	$names = array();
	foreach ( sac_default_projects() as $project ) {
		$names[ trim( $project[0] ) ] = true;
	}
	return array_keys( $names );
}

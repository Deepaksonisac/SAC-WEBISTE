export type Industry =
  | 'Hospitality'
  | 'Healthcare'
  | 'Infrastructure & Commercial'
  | 'Industrial'

export interface Project {
  client: string
  location: string
  industry: Industry
  image: string
  tags: string[]
}

export const PROJECTS: Project[] = [
  {
    client: 'Taj Sawai Man Mahal (Rambagh)',
    location: 'Jaipur',
    industry: 'Hospitality',
    image: '/images/projects/taj-sawai-man-mahal.avif',
    tags: ['Hospitality ELV Solutions'],
  },
  {
    client: 'Hyatt Place',
    location: 'Jaipur',
    industry: 'Hospitality',
    image: '/images/projects/hyatt-place.webp',
    tags: ['Hospitality ELV Solutions'],
  },
  {
    client: 'Hilton',
    location: 'Congo',
    industry: 'Hospitality',
    image: '/images/projects/hilton.avif',
    tags: ['Hospitality ELV Solutions'],
  },
  {
    client: 'Westin Jaipur',
    location: 'Jaipur',
    industry: 'Hospitality',
    image: '/images/projects/westin-jaipur.avif',
    tags: ['Hospitality ELV Solutions'],
  },
  {
    client: 'Westin Spa & Resorts',
    location: 'Jaipur',
    industry: 'Hospitality',
    image: '/images/projects/westin-spa-resorts.jfif',
    tags: ['Hospitality ELV Solutions'],
  },
  {
    client: 'Signia By Hilton',
    location: 'Jaipur',
    industry: 'Hospitality',
    image: '/images/projects/signia-by-hilton.jpg',
    tags: ['Hospitality ELV Solutions'],
  },
  {
    client: 'ITC Mementos',
    location: 'Jaipur',
    industry: 'Hospitality',
    image: '/images/projects/itc-mementos-phase-1.jpg',
    tags: ['Hospitality ELV Solutions'],
  },
  {
    client: 'Geetanjali Institute of Medical Sciences (GIMS)',
    location: 'Jaipur',
    industry: 'Hospitality',
    image: '/images/gims.jpg',
    tags: ['Hospitality ELV Solutions'],
  },
  {
    client: 'ONGC Crew Changing Facility',
    location: 'Mumbai',
    industry: 'Hospitality',
    image: '/images/projects/ongc-crew-changing-facility.jpg',
    tags: ['ELV & Integrated Systems'],
  },
  {
    client: 'SMS Super Specialty Hospital',
    location: 'Jaipur',
    industry: 'Healthcare',
    image: '/images/projects/sms-super-specialty-hospital.avif',
    tags: ['Healthcare ELV Solutions'],
  },
  {
    client: 'SMS Cardiology Block',
    location: 'Jaipur',
    industry: 'Healthcare',
    image: '/images/projects/sms-cardiology-block.jfif',
    tags: ['Healthcare ELV Solutions'],
  },
  {
    client: 'National Institute of Homeopathy',
    location: 'Narela, Delhi',
    industry: 'Healthcare',
    image: '/images/projects/national-institute-homeopathy.jpg',
    tags: ['Healthcare ELV Solutions'],
  },
  {
    client: 'Regency Hospital',
    location: 'Gorakhpur',
    industry: 'Healthcare',
    image: '/images/projects/regency-hospital-gorakhpur.webp',
    tags: ['Healthcare ELV Solutions'],
  },
  {
    client: 'Regency Hospital',
    location: 'Kanpur',
    industry: 'Healthcare',
    image: '/images/projects/regency-hospital-kanpur.webp',
    tags: ['Healthcare ELV Solutions'],
  },
  {
    client: 'Oil India Limited',
    location: 'Duliajan, Assam',
    industry: 'Healthcare',
    image: '/images/projects/oil-hospital.webp',
    tags: ['Healthcare ELV Solutions'],
  },
  {
    client: 'New Civil Hospital',
    location: 'Palitana Gujrat',
    industry: 'Healthcare',
    image: '/images/projects/new-civil-hospital.jfif',
    tags: ['Healthcare ELV Solutions'],
  },
  {
    client: 'Ayodhya Airport',
    location: 'Ayodhya',
    industry: 'Infrastructure & Commercial',
    image: '/images/projects/ayodhya-airport.jpg',
    tags: ['Infrastructure ELV Solutions'],
  },
  {
    client: 'Utkarsh Small Finance Bank',
    location: 'Varanasi',
    industry: 'Infrastructure & Commercial',
    image: '/images/projects/utkarsh-bank-phase-2.png',
    tags: ['Commercial ELV Solutions'],
  },
  {
    client: 'MS Emerging Commercial Building',
    location: 'Jaipur',
    industry: 'Infrastructure & Commercial',
    image: '/ms-emerging-building.png',
    tags: ['Commercial Building Solutions'],
  },
  {
    client: 'Minto Hall',
    location: 'Bhopal',
    industry: 'Infrastructure & Commercial',
    image: '/images/projects/minto-hall.png',
    tags: ['Integrated ELV Solutions'],
  },
  {
    client: 'Jagatpura World Center',
    location: 'Jaipur',
    industry: 'Infrastructure & Commercial',
    image: '/jagatpura-world-center-new.jfif',
    tags: ['Commercial Building Solutions'],
  },
  {
    client: 'NTPC',
    location: 'India',
    industry: 'Industrial',
    image: '/images/projects/ntpc.jpg',
    tags: ['Industrial ELV Solutions'],
  },
  {
    client: 'NPCIL',
    location: 'India',
    industry: 'Industrial',
    image: '/images/projects/npcil.jpg',
    tags: ['Industrial ELV Solutions'],
  },
  {
    client: 'IOCL',
    location: 'India',
    industry: 'Industrial',
    image: '/images/projects/iocl.png',
    tags: ['Industrial ELV Solutions'],
  },
  {
    client: 'Cairn India Vedanta',
    location: 'India',
    industry: 'Industrial',
    image: '/images/projects/cairn-india-vedanta.jpg',
    tags: ['Industrial ELV Solutions'],
  },
  {
    client: 'HPCL',
    location: 'India',
    industry: 'Industrial',
    image: '/images/projects/hpcl.jpg',
    tags: ['Industrial ELV Solutions'],
  },
]

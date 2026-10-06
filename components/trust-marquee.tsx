const clients = [
  'Cairn India Ltd.',
  'Nuclear Power Corporation of India Ltd. (NPCIL)',
  'Suratgarh Thermal Power Station',
  'Rashtriya Chemical Fertilizers Ltd.',
  'Shree Cement',
  'Birla Corporation',
  'Satna Cement Works',
  'Hindustan Zinc',

  'Taj Sawai Man Mahal (Rambagh)',
  'Hyatt Place',
  'Hilton',
  'Westin Jaipur',
  'Westin Spa & Resorts',
  'Signia By Hilton',
  'ITC Mementos Phase-1',
  'ITC Mementos Phase-2',
  'ONGC Crew Changing Facility',

  'SMS Super Specialty Hospital',
  'SMS Cardiology Block',
  'National Institute of Homeopathy',
  'Regency Hospital Gorakhpur',
  'Regency Hospital Kanpur',
  'OIL Hospital',
  'Govt Medical College',

  'Ayodhya Airport',
  'Utkarsh Small Finance Bank Phase-1',
  'Utkarsh Small Finance Bank Phase-2',
  'MS Emerging Commercial Building',
  'Minto Hall',
  'Jagatpura World Center',
  'RSRDC Toll Plazas',

  'Prayagraj Command Centre',
  'Raipur Command Centre',
  'NDMC Command Centre',
  'RRVPNL Command Centre',

  'The Sanskaar Valley School',
  'Allen Institute',

  'Tirupati Airport',
  'Kishangarh Airport',
]

export function TrustMarquee() {
  return (
    <section className="border-y border-border bg-card/40 py-8" aria-label="Trusted by">
      <p className="mb-6 text-center text-xs font-medium uppercase tracking-[0.22em] text-muted-foreground">
        Trusted across India&apos;s most demanding facilities
      </p>
      <div className="relative overflow-hidden [mask-image:linear-gradient(to_right,transparent,black_12%,black_88%,transparent)]">
        <div className="sac-marquee flex w-max items-center gap-12 pr-12">
          {[...clients, ...clients].map((name, i) => (
            <span
              key={i}
              className="whitespace-nowrap font-heading text-lg font-semibold tracking-tight text-muted-foreground/80"
            >
              {name}
            </span>
          ))}
        </div>
      </div>
    </section>
  )
}



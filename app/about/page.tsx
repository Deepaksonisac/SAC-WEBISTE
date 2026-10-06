import type { Metadata } from 'next'
import { PageHeader } from '@/components/page-header'
import { CompanyOverview } from '@/components/about/company-overview'
import { LeadershipSection } from '@/components/leadership-section'
import { CtaBand } from '@/components/cta-band'

export const metadata: Metadata = {
  title: 'About | Secure Automation Consultants',
  description:
    'Since 2010, SAC has engineered tailor-made Building Security, Management & Automation solutions for India\u2019s most demanding facilities. Meet the team behind the engineering.',
}

export default function AboutPage() {
  return (
    <>
      <PageHeader
        eyebrow="About SAC"
        title="Engineering trust since 2010"
        subtitle="A Jaipur-based systems integrator built around a simple idea — that the best security and automation is engineered around your requirement, not sold from a catalogue."
      />
      <CompanyOverview />
      <LeadershipSection />
      <CtaBand />
    </>
  )
}

import type { Metadata } from 'next'
import { PageHeader } from '@/components/page-header'
import { SolutionsSection } from '@/components/solutions-section'
import { CtaBand } from '@/components/cta-band'

export const metadata: Metadata = {
  title: 'Solutions | Secure Automation Consultants',
  description:
    'IP video surveillance, access control, fire detection & suppression, building management systems, IT networking, and PAGA/PIDS — engineered and delivered as one integrated system.',
}
export default function SolutionsPage() {
  return (
    <> 
      <PageHeader
        eyebrow="Solutions"
        title="Security & automation, engineered as one system"
        subtitle="Six integrated disciplines delivered by a single accountable partner — from surveillance and access control to fire, BMS, networking and public address."
      />
      <SolutionsSection />
      <CtaBand />
    </>
  )
}

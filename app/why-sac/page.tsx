import type { Metadata } from 'next'
import { PageHeader } from '@/components/page-header'
import { WhySacSection } from '@/components/why-sac-section'
import { CtaBand } from '@/components/cta-band'

export const metadata: Metadata = {
  title: 'Why SAC | Secure Automation Consultants',
  description:
    'People-first business, value for money, and a culture of Integrity, Excellence, Teamwork and Accountability — the principles behind every SAC engagement.',
}

export default function WhySacPage() {
  return (
    <>
      <PageHeader
        eyebrow="Why SAC"
        title="Business is people"
        subtitle="Our work is engineered on three value pillars that hold up under pressure — a people-first model, disciplined value for money, and a culture built to last."
      />
      <WhySacSection />
      <CtaBand />
    </>
  )
}

import type { Metadata } from 'next'
import { PageHeader } from '@/components/page-header'
import { ProjectsSection } from '@/components/projects-section'
import { CtaBand } from '@/components/cta-band'

export const metadata: Metadata = {
  title: 'Projects | Secure Automation Consultants',
  description:
    'Flagship SAC deployments across energy & power, cement & manufacturing, hospitality, government & smart cities, healthcare, education, aviation and infrastructure.',
}

export default function ProjectsPage() {
  return (
    <>
      <PageHeader
        eyebrow="Trusted Across Mission-Critical Environments"
        title="Trusted on India's most critical sites"
        subtitle="Explore SAC’s experience across healthcare, hospitality, infrastructure and commercial facilities — delivering reliable integrated security, ELV and building automation solutions."
      />
      <ProjectsSection />
      <CtaBand />
    </>
  )
}

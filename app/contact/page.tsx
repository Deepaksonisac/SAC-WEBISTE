import type { Metadata } from 'next'
import { PageHeader } from '@/components/page-header'
import { ContactSection } from '@/components/contact-section'

export const metadata: Metadata = {
  title: 'Contact | SAC — Secure Automation Consultants',
  description:
    'Get in touch with SAC for security, surveillance and building automation projects. Based in Jaipur, serving critical facilities across India.',
}

export default function ContactPage() {
  return (
    <>
      <PageHeader
        eyebrow="Contact"
        title="Let's engineer your next secure facility"
        subtitle="Tell us about your site and requirements. Our team responds to every enquiry within one business day."
      />
      <ContactSection />
    </>
  )
}

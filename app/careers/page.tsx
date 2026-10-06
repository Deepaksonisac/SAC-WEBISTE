import type { Metadata } from "next"
import Link from "next/link"
import {
  ArrowRight,
  BriefcaseBusiness,
  Building2,
  CheckCircle2,
  GraduationCap,
  MapPin,
  Network,
  Users,
} from "lucide-react"

import { PageHeader } from "@/components/page-header"
import { Reveal } from "@/components/reveal"
import { CtaBand } from "@/components/cta-band"

export const metadata: Metadata = {
  title: "Careers | Secure Automation Consultants",
  description:
    "Explore career opportunities at Secure Automation Consultants in building automation, ELV, BMS, CCTV, access control, fire detection and integrated security solutions.",
}

const benefits = [
  {
    icon: GraduationCap,
    title: "Professional Growth",
    description:
      "Build your career through real-world exposure to advanced automation, security and ELV technologies.",
  },
  {
    icon: Building2,
    title: "Diverse Projects",
    description:
      "Work across hospitality, healthcare, commercial, industrial and infrastructure projects.",
  },
  {
    icon: Network,
    title: "Learning & Development",
    description:
      "Gain practical knowledge of leading technologies, systems and modern engineering practices.",
  },
  {
    icon: Users,
    title: "Collaborative Culture",
    description:
      "Work alongside experienced engineers, project teams and technology professionals.",
  },
]

const responsibilities = [
  "Project planning, scheduling and execution coordination",
  "Material planning, tracking and site coordination",
  "BMS, CCTV, Access Control, Fire Alarm and PA system coordination",
  "Project documentation and progress monitoring",
  "Testing & commissioning coordination",
  "Coordination with clients, consultants and project teams",
]

export default function CareersPage() {
  return (
    <>
      {/* =====================================================
          HERO
      ===================================================== */}
      <PageHeader
        eyebrow="Careers"
        title="Build the future with us"
        subtitle="Join Secure Automation Consultants and build your career while delivering intelligent building automation, integrated security, ELV and smart infrastructure solutions."
      />

      {/* =====================================================
          INTRODUCTION
      ===================================================== */}
      <section className="py-20 md:py-28">
        <div className="mx-auto max-w-7xl px-6 lg:px-8">
          <div className="grid items-center gap-12 lg:grid-cols-2 lg:gap-20">

            <Reveal>
              <div>
                <p className="text-sm font-bold uppercase tracking-[0.22em] text-primary">
                  Careers at SAC
                </p>

                <h2 className="mt-4 text-4xl font-bold tracking-tight text-foreground md:text-5xl">
                  Grow with Secure
                  <span className="block text-primary">
                    Automation Consultants
                  </span>
                </h2>

                <p className="mt-7 max-w-2xl text-lg leading-8 text-muted-foreground">
                  At Secure Automation Consultants, our people are the
                  foundation of our success. We provide opportunities to work
                  on challenging projects across Building Management Systems,
                  CCTV Surveillance, Access Control, Fire Detection & Alarm,
                  Public Address, IT Networking and integrated ELV solutions.
                </p>

                <p className="mt-5 max-w-2xl text-lg leading-8 text-muted-foreground">
                  Whether you are an experienced professional or developing
                  your engineering career, SAC provides an environment where
                  technical knowledge, responsibility and continuous learning
                  come together.
                </p>

                <Link
                  href="#openings"
                  className="mt-8 inline-flex items-center gap-2 rounded-lg bg-primary px-6 py-3 font-semibold text-primary-foreground transition hover:opacity-90"
                >
                  View Current Openings
                  <ArrowRight className="h-4 w-4" />
                </Link>
              </div>
            </Reveal>

            <Reveal index={1}>
              <div className="relative overflow-hidden rounded-3xl border border-primary/20 bg-primary/5 p-10 md:p-12">

                <div className="absolute -right-20 -top-20 h-64 w-64 rounded-full bg-primary/10 blur-3xl" />

                <div className="relative">
                  <div className="flex h-16 w-16 items-center justify-center rounded-2xl bg-primary text-primary-foreground">
                    <BriefcaseBusiness className="h-8 w-8" />
                  </div>

                  <h3 className="mt-8 text-3xl font-bold">
                    Engineer. Learn. Grow.
                  </h3>

                  <p className="mt-5 text-lg leading-8 text-muted-foreground">
                    Be part of a team delivering reliable, intelligent and
                    future-ready technology solutions for demanding facilities
                    and infrastructure.
                  </p>

                  <div className="mt-8 grid gap-4 sm:grid-cols-2">

                    <div className="rounded-xl border border-border bg-background p-5">
                      <p className="text-2xl font-bold text-primary">
                        Smart
                      </p>
                      <p className="mt-1 text-sm text-muted-foreground">
                        Building Technologies
                      </p>
                    </div>

                    <div className="rounded-xl border border-border bg-background p-5">
                      <p className="text-2xl font-bold text-primary">
                        Integrated
                      </p>
                      <p className="mt-1 text-sm text-muted-foreground">
                        ELV Solutions
                      </p>
                    </div>

                  </div>
                </div>
              </div>
            </Reveal>

          </div>
        </div>
      </section>

      {/* =====================================================
          WHY JOIN SAC
      ===================================================== */}
      <section className="border-y border-border bg-primary/[0.035] py-20 md:py-28">
        <div className="mx-auto max-w-7xl px-6 lg:px-8">

          <Reveal>
            <div className="mx-auto max-w-3xl text-center">
              <p className="text-sm font-bold uppercase tracking-[0.22em] text-primary">
                Why Join SAC
              </p>

              <h2 className="mt-4 text-4xl font-bold tracking-tight md:text-5xl">
                Build more than a career
              </h2>

              <p className="mt-6 text-lg leading-8 text-muted-foreground">
                Grow with a team focused on engineering excellence, practical
                learning and delivering technology that makes facilities
                smarter, safer and more efficient.
              </p>
            </div>
          </Reveal>

          <div className="mt-14 grid gap-6 md:grid-cols-2 lg:grid-cols-4">

            {benefits.map((item, index) => {
              const Icon = item.icon

              return (
                <Reveal key={item.title} index={index}>
                  <div className="group h-full rounded-2xl border border-border bg-background p-7 shadow-sm transition duration-300 hover:-translate-y-1 hover:border-primary/40 hover:shadow-lg">

                    <div className="flex h-13 w-13 items-center justify-center rounded-xl bg-primary/10 text-primary">
                      <Icon className="h-6 w-6" />
                    </div>

                    <h3 className="mt-6 text-xl font-bold">
                      {item.title}
                    </h3>

                    <p className="mt-3 leading-7 text-muted-foreground">
                      {item.description}
                    </p>

                  </div>
                </Reveal>
              )
            })}

          </div>
        </div>
      </section>

      {/* =====================================================
          CURRENT OPENINGS
      ===================================================== */}
      <section id="openings" className="py-20 md:py-28">
        <div className="mx-auto max-w-7xl px-6 lg:px-8">

          <Reveal>
            <div className="max-w-3xl">

              <p className="text-sm font-bold uppercase tracking-[0.22em] text-primary">
                Opportunities
              </p>

              <h2 className="mt-4 text-4xl font-bold tracking-tight md:text-5xl">
                Current openings
              </h2>

              <p className="mt-5 text-lg leading-8 text-muted-foreground">
                Explore opportunities to join our engineering, project and
                technology teams.
              </p>

            </div>
          </Reveal>

          <Reveal index={1}>
            <div className="mt-12 overflow-hidden rounded-2xl border border-border bg-background shadow-sm">

              <div className="border-b border-border bg-primary/[0.04] p-7 md:p-9">

                <div className="flex flex-col justify-between gap-6 lg:flex-row lg:items-center">

                  <div>
                    <div className="flex flex-wrap items-center gap-3">

                      <span className="rounded-full bg-primary/10 px-3 py-1 text-xs font-bold uppercase tracking-wider text-primary">
                        Now Hiring
                      </span>

                      <span className="flex items-center gap-1.5 text-sm text-muted-foreground">
                        <MapPin className="h-4 w-4 text-primary" />
                        Jaipur, Rajasthan
                      </span>

                    </div>

                    <h3 className="mt-5 text-2xl font-bold md:text-3xl">
                      Planning Engineer – ELV Systems
                    </h3>
                  </div>

                  <Link
                    href="#apply"
                    className="inline-flex shrink-0 items-center justify-center gap-2 rounded-lg bg-primary px-6 py-3 font-semibold text-primary-foreground transition hover:opacity-90"
                  >
                    Apply Now
                    <ArrowRight className="h-4 w-4" />
                  </Link>

                </div>
              </div>

              <div className="p-7 md:p-9">

                <div className="grid gap-6 border-b border-border pb-8 sm:grid-cols-3">

                  <div>
                    <p className="text-xs font-bold uppercase tracking-wider text-muted-foreground">
                      Experience
                    </p>
                    <p className="mt-2 text-lg font-semibold">
                      3–5 Years
                    </p>
                  </div>

                  <div>
                    <p className="text-xs font-bold uppercase tracking-wider text-muted-foreground">
                      Department
                    </p>
                    <p className="mt-2 text-lg font-semibold">
                      Projects / ELV
                    </p>
                  </div>

                  <div>
                    <p className="text-xs font-bold uppercase tracking-wider text-muted-foreground">
                      Employment
                    </p>
                    <p className="mt-2 text-lg font-semibold">
                      Full Time
                    </p>
                  </div>

                </div>

                <div className="mt-8 grid gap-10 lg:grid-cols-2">

                  <div>
                    <h4 className="text-lg font-bold">
                      Required Knowledge
                    </h4>

                    <p className="mt-4 leading-7 text-muted-foreground">
                      Strong understanding of BMS, CCTV, Access Control,
                      Fire Alarm, Public Address and IT Networking systems.
                    </p>

                    <div className="mt-6 flex flex-wrap gap-2">
                      {[
                        "BMS",
                        "CCTV",
                        "Access Control",
                        "Fire Alarm",
                        "Public Address",
                        "IT Networking",
                      ].map((skill) => (
                        <span
                          key={skill}
                          className="rounded-full border border-primary/20 bg-primary/5 px-3 py-1.5 text-sm font-medium text-primary"
                        >
                          {skill}
                        </span>
                      ))}
                    </div>
                  </div>

                  <div>
                    <h4 className="text-lg font-bold">
                      Key Responsibilities
                    </h4>

                    <div className="mt-4 space-y-3">

                      {responsibilities.map((item) => (
                        <div
                          key={item}
                          className="flex items-start gap-3"
                        >
                          <CheckCircle2 className="mt-0.5 h-5 w-5 shrink-0 text-primary" />

                          <p className="leading-6 text-muted-foreground">
                            {item}
                          </p>
                        </div>
                      ))}

                    </div>
                  </div>

                </div>
              </div>
            </div>
          </Reveal>

        </div>
      </section>

      {/* =====================================================
          APPLICATION
      ===================================================== */}
      <section
        id="apply"
        className="border-y border-border bg-primary/[0.035] py-20 md:py-28"
      >
        <div className="mx-auto max-w-7xl px-6 lg:px-8">

          <div className="grid gap-12 lg:grid-cols-[0.8fr_1.2fr] lg:gap-16">

            <Reveal>
              <div>

                <p className="text-sm font-bold uppercase tracking-[0.22em] text-primary">
                  Join Our Team
                </p>

                <h2 className="mt-4 text-4xl font-bold tracking-tight md:text-5xl">
                  Your next opportunity starts here
                </h2>

                <p className="mt-6 text-lg leading-8 text-muted-foreground">
                  If you are passionate about smart buildings, automation,
                  security systems and engineering excellence, we would like
                  to hear from you.
                </p>

                <div className="mt-9 rounded-2xl border border-border bg-background p-7">

                  <h3 className="text-lg font-bold">
                    Don&apos;t see the right position?
                  </h3>

                  <p className="mt-3 leading-7 text-muted-foreground">
                    Share your profile with us. Suitable candidates may be
                    considered for future opportunities at Secure Automation
                    Consultants.
                  </p>

                </div>

              </div>
            </Reveal>

            <Reveal index={1}>
              <div className="rounded-2xl border border-border bg-background p-7 shadow-sm md:p-9">

                <h3 className="text-2xl font-bold">
                  Apply for an opportunity
                </h3>

                <p className="mt-2 text-muted-foreground">
                  Complete the form below and share your professional profile
                  with our team.
                </p>

                <form className="mt-8">

                  <div className="grid gap-6 sm:grid-cols-2">

                    <div>
                      <label
                        htmlFor="fullName"
                        className="text-sm font-semibold"
                      >
                        Full Name *
                      </label>

                      <input
                        id="fullName"
                        name="fullName"
                        required
                        type="text"
                        placeholder="Your full name"
                        className="mt-2 h-12 w-full rounded-lg border border-border bg-background px-4 outline-none transition focus:border-primary focus:ring-2 focus:ring-primary/10"
                      />
                    </div>

                    <div>
                      <label
                        htmlFor="email"
                        className="text-sm font-semibold"
                      >
                        Email Address *
                      </label>

                      <input
                        id="email"
                        name="email"
                        required
                        type="email"
                        placeholder="you@example.com"
                        className="mt-2 h-12 w-full rounded-lg border border-border bg-background px-4 outline-none transition focus:border-primary focus:ring-2 focus:ring-primary/10"
                      />
                    </div>

                    <div>
                      <label
                        htmlFor="phone"
                        className="text-sm font-semibold"
                      >
                        Phone Number *
                      </label>

                      <input
                        id="phone"
                        name="phone"
                        required
                        type="tel"
                        placeholder="+91"
                        className="mt-2 h-12 w-full rounded-lg border border-border bg-background px-4 outline-none transition focus:border-primary focus:ring-2 focus:ring-primary/10"
                      />
                    </div>

                    <div>
                      <label
                        htmlFor="location"
                        className="text-sm font-semibold"
                      >
                        Current Location
                      </label>

                      <input
                        id="location"
                        name="location"
                        type="text"
                        placeholder="City, State"
                        className="mt-2 h-12 w-full rounded-lg border border-border bg-background px-4 outline-none transition focus:border-primary focus:ring-2 focus:ring-primary/10"
                      />
                    </div>

                    <div>
                      <label
                        htmlFor="position"
                        className="text-sm font-semibold"
                      >
                        Position Applied For *
                      </label>

                      <select
                        id="position"
                        name="position"
                        required
                        defaultValue=""
                        className="mt-2 h-12 w-full rounded-lg border border-border bg-background px-4 outline-none transition focus:border-primary focus:ring-2 focus:ring-primary/10"
                      >
                        <option value="" disabled>
                          Select position
                        </option>

                        <option value="Planning Engineer - ELV Systems">
                          Planning Engineer – ELV Systems
                        </option>

                        <option value="General Application">
                          General Application
                        </option>
                      </select>
                    </div>

                    <div>
                      <label
                        htmlFor="experience"
                        className="text-sm font-semibold"
                      >
                        Total Experience
                      </label>

                      <input
                        id="experience"
                        name="experience"
                        type="text"
                        placeholder="e.g. 4 Years"
                        className="mt-2 h-12 w-full rounded-lg border border-border bg-background px-4 outline-none transition focus:border-primary focus:ring-2 focus:ring-primary/10"
                      />
                    </div>

                    <div className="sm:col-span-2">
                      <label
                        htmlFor="company"
                        className="text-sm font-semibold"
                      >
                        Current Company
                      </label>

                      <input
                        id="company"
                        name="company"
                        type="text"
                        placeholder="Current organization"
                        className="mt-2 h-12 w-full rounded-lg border border-border bg-background px-4 outline-none transition focus:border-primary focus:ring-2 focus:ring-primary/10"
                      />
                    </div>

                    <div className="sm:col-span-2">
                      <label
                        htmlFor="message"
                        className="text-sm font-semibold"
                      >
                        Message / Cover Note
                      </label>

                      <textarea
                        id="message"
                        name="message"
                        rows={5}
                        placeholder="Tell us about your experience and interest in this role."
                        className="mt-2 w-full resize-none rounded-lg border border-border bg-background px-4 py-3 outline-none transition focus:border-primary focus:ring-2 focus:ring-primary/10"
                      />
                    </div>

                    <div className="sm:col-span-2">

                      <label
                        htmlFor="resume"
                        className="text-sm font-semibold"
                      >
                        Upload Resume / CV *
                      </label>

                      <div className="mt-2 rounded-xl border border-dashed border-primary/30 bg-primary/[0.025] p-5">

                        <input
                          id="resume"
                          name="resume"
                          required
                          type="file"
                          accept=".pdf,.doc,.docx"
                          className="w-full text-sm text-muted-foreground file:mr-4 file:rounded-lg file:border-0 file:bg-primary file:px-4 file:py-2.5 file:font-semibold file:text-primary-foreground"
                        />

                        <p className="mt-3 text-xs text-muted-foreground">
                          Accepted formats: PDF, DOC, DOCX
                        </p>

                      </div>
                    </div>

                  </div>

                  <button
                    type="button"
                    className="mt-8 inline-flex w-full items-center justify-center gap-2 rounded-lg bg-primary px-7 py-3.5 font-semibold text-primary-foreground transition hover:opacity-90 sm:w-auto"
                  >
                    Submit Application
                    <ArrowRight className="h-4 w-4" />
                  </button>

                  <p className="mt-4 text-xs leading-5 text-muted-foreground">
                    Application submission will become active after the form
                    is connected to the recruitment backend.
                  </p>

                </form>

              </div>
            </Reveal>

          </div>
        </div>
      </section>

      {/* =====================================================
          FINAL CTA
      ===================================================== */}
      <CtaBand
        title="Ready to build your career with SAC?"
        subtitle="Join a team engineering secure, intelligent and future-ready facilities through integrated technology."
      />
    </>
  )
}
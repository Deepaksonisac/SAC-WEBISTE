import Image from 'next/image'
import Link from 'next/link'
import { cn } from '@/lib/utils'

const LOGO_WIDTH = 1774
const LOGO_HEIGHT = 887

const VARIANTS = {
  header: {
    className: 'w-[120px] sm:w-[150px] lg:w-[176px]',
    sizes: '(min-width: 1024px) 176px, (min-width: 640px) 150px, 120px',
  },
  footer: {
    className: 'w-[200px] rounded-lg bg-background',
    sizes: '200px',
  },
  menu: {
    className: 'w-[132px]',
    sizes: '132px',
  },
} as const

export function SiteLogo({
  className,
  variant = 'header',
  priority = false,
}: {
  className?: string
  variant?: keyof typeof VARIANTS
  priority?: boolean
}) {
  const { className: sizeClassName, sizes } = VARIANTS[variant]

  return (
    <Link
      href="/"
      className={cn('flex shrink-0 items-center', className)}
      aria-label="Secure Automation Consultants home"
    >
      <Image
        src="/images/sac-logo-business-services.png"
        alt="SAC — business is people. BMS, Security, Fire, IT, AV"
        width={LOGO_WIDTH}
        height={LOGO_HEIGHT}
        sizes={sizes}
        priority={priority}
        className={cn('h-auto max-w-none object-contain', sizeClassName)}
      />
    </Link>
  )
}
